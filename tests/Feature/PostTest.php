<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_when_no_blog_post()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No Blog Post !');
    }

    public function test_when_blog_post_is_1()
    {
//        arrange
        $post = new BlogPost();
        $post->title = 'New Blog Post';
        $post->content = 'This is content of blog post';
        $post->save();

//        act
        $response = $this->get('/posts');

//        assert
        $response->assertSeeText('New Blog Post');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Blog Post',
            'content' => 'This is content of blog post'
        ]);
    }

    public function test_store_blog_post_is_valid()
    {
//        arrange
        $body = [
            'title' => 'Valid Title',
            'content' => 'At least 10 characters'
        ];

//        act
        $this->post('/posts', $body)
            ->assertStatus(302)
            ->assertSessionHas('status');

//        assert
        $this->assertEquals(session('status'), 'The blog post was created !');
    }
}
