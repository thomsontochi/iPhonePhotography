<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;
use App\Events\CommentWritten;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnlockCommentAchievementsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function testUnlockingCommentAchievements()
    {
        // Create a user (adjust the details based on your implementation)
        $user = User::factory()->create();

        // Create a comment (adjust the details based on your implementation)
        $comment = Comment::factory()->create();

        // Attach the comment to the user
        $user->comments()->save($comment);

        // Dispatch the CommentWritten event
        CommentWritten::dispatch($comment);

        // Assertions for unlocking achievements and badges
        // $this->assertTrue($user->unlocked_achievements->contains('First Comment Written'));
        
        $this->assertTrue($user->badges->contains('name', 'Master'));

    }
}
