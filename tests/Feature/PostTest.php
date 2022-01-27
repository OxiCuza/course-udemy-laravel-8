<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private function createDummyData(): BlogPost
    {
        $post = new BlogPost();
        $post->title = 'New Blog Post';
        $post->content = 'This is content of blog post';
        $post->save();

        return $post;
    }

    public function test_when_no_blog_post()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No Blog Post !');
    }

    public function test_when_blog_post_is_1()
    {
//        arrange
        $post = $this->createDummyData();

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

    public function test_store_blog_post_is_fail()
    {
//        arrange
        $body = [
            'title' => 'x',
            'content' => 'xx',
        ];

//        act
        $this->post('/posts', $body)
            ->assertStatus(302)
            ->assertSessionHas('errors');

//        assert
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function test_update_blog_post_is_valid()
    {
//        arrange
        $post = $this->createDummyData();

        $body = [
            'title' => 'A New Blog Post !',
            'content' => 'A new content of blog post',
        ];

//        assert
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Blog Post',
            'content' => 'This is content of blog post',
        ]);

//        act
        $this->put("/posts/{$post->id}", $body)
            ->assertStatus(302)
            ->assertSessionHas('status');

//        assert
        $this->assertEquals(session('status'), 'The blog post was updated !');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New Blog Post',
            'content' => 'This is content of blog post',
        ]);
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A New Blog Post !',
            'content' => 'A new content of blog post',
        ]);
    }

    public function test_destroy_blog_post()
    {
        $post = $this->createDummyData();
        $this->assertNotNull($post);

        $this->delete(route('posts.destroy', $post->id))
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted !');
        $deletedPost = BlogPost::find($post->id);
        $this->assertNull($deletedPost);
    }
}
