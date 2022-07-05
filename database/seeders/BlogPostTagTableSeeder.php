<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $tagCount = Tag::all()->count();

            if ($tagCount == 0) {
                $this->command->info('Cannot sync tag, because we do not have tag value');
                return;
            }

            $blogPosts = BlogPost::all();

            $blogPosts->each(function (BlogPost $blogPost) use ($tagCount) {
                $take = random_int(1, $tagCount);
                $tagIdCollection = Tag::inRandomOrder()->take($take)->pluck('id');
                $blogPost->tags()->sync($tagIdCollection);
            });

            $this->command->info('Blog Post and Tag success synchronize !');
            DB::commit();
        } catch (\Exception $error) {
            $this->command->info($error);
            DB::rollBack();
        }
    }
}
