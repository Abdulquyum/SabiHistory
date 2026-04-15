<?php

namespace App\Services;

use App\Models\TwitterPost;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService
{
    protected $connection;
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
        
        // Initialize Twitter/X API connection
        $this->connection = new TwitterOAuth(
            env('TWITTER_API_KEY'),
            env('TWITTER_API_SECRET'),
            env('TWITTER_ACCESS_TOKEN'),
            env('TWITTER_ACCESS_TOKEN_SECRET')
        );
        
        $this->connection->setApiVersion('2');
    }

    // Post "Today in History" to X
    public function postTodayInHistory()
    {
        $today = date('Y-m-d');
        
        // Check if already posted today
        $existing = TwitterPost::where('type', 'today_history')
            ->where('scheduled_date', $today)
            ->first();
        
        if ($existing && $existing->posted_at) {
            return ['success' => false, 'message' => 'Already posted today'];
        }
        
        // Generate content if not exists
        if (!$existing) {
            $content = $this->aiService->generateTodayInHistory();
            $existing = TwitterPost::create([
                'type' => 'today_history',
                'content' => $content,
                'scheduled_date' => $today
            ]);
        }
        
        // Post to X
        try {
            $response = $this->connection->post('tweets', [
                'text' => $existing->content . "\n\n#TodayInHistory #HistoryFacts #SabiHistory"
            ]);
            
            if (isset($response->data->id)) {
                $existing->update([
                    'posted_at' => now(),
                    'twitter_post_id' => $response->data->id
                ]);
                
                return ['success' => true, 'tweet_id' => $response->data->id];
            }
            
            return ['success' => false, 'error' => 'Failed to post'];
            
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Post "Did You Know" to X
    public function postDidYouKnow()
    {
        $today = date('Y-m-d');
        
        // Check if already posted today
        $existing = TwitterPost::where('type', 'did_you_know')
            ->where('scheduled_date', $today)
            ->first();
        
        if ($existing && $existing->posted_at) {
            return ['success' => false, 'message' => 'Already posted today'];
        }
        
        // Generate content if not exists
        if (!$existing) {
            $content = $this->aiService->generateDidYouKnow();
            $existing = TwitterPost::create([
                'type' => 'did_you_know',
                'content' => $content,
                'scheduled_date' => $today
            ]);
        }
        
        // Post to X
        try {
            $response = $this->connection->post('tweets', [
                'text' => $existing->content . "\n\n#DidYouKnow #HistoryTrivia #SabiHistory"
            ]);
            
            if (isset($response->data->id)) {
                $existing->update([
                    'posted_at' => now(),
                    'twitter_post_id' => $response->data->id
                ]);
                
                return ['success' => true, 'tweet_id' => $response->data->id];
            }
            
            return ['success' => false, 'error' => 'Failed to post'];
            
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Post both (morning and evening)
    public function postMorningHistory()
    {
        return $this->postTodayInHistory();
    }

    public function postEveningTrivia()
    {
        return $this->postDidYouKnow();
    }
}