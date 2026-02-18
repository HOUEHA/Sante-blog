<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterSubscription;
use App\Mail\NewArticleNotification;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email'
        ]);

        try {
            $newsletter = Newsletter::create([
                'email' => $validated['email'],
                'is_active' => true
            ]);

            // Send welcome email
            Mail::to($validated['email'])->send(new NewsletterSubscription($newsletter));

            return response()->json([
                'message' => 'Inscription réussie! Merci de votre confiance.',
                'newsletter' => $newsletter
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l\'inscription. Veuillez réessayer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function unsubscribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        $newsletter = Newsletter::where('email', $validated['email'])->first();
        
        if (!$newsletter) {
            return response()->json([
                'message' => 'Email non trouvé dans notre liste.'
            ], 404);
        }

        $newsletter->update(['is_active' => false]);

        return response()->json([
            'message' => 'Désinscription réussie.'
        ]);
    }

    public function notifyNewArticle($article): void
    {
        $subscribers = Newsletter::where('is_active', true)->get();

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewArticleNotification($article));
            } catch (\Exception $e) {
                \Log::error('Failed to send newsletter to ' . $subscriber->email . ': ' . $e->getMessage());
            }
        }
    }

    public function getSubscribers(): JsonResponse
    {
        $subscribers = Newsletter::where('is_active', true)
            ->orderBy('subscribed_at', 'desc')
            ->paginate(50);

        return response()->json($subscribers);
    }
}
