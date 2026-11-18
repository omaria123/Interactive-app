<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'author@example.com'],
            [
                'name' => 'Александр Иванов',
                'password' => Hash::make('password123'),
            ]
        );

        $tagLaravel = Tag::firstOrCreate(['name' => 'Laravel']);
        $tagPhp = Tag::firstOrCreate(['name' => 'PHP']);
        $tagFrontend = Tag::firstOrCreate(['name' => 'Frontend']);
        $tagArch = Tag::firstOrCreate(['name' => 'Архитектура']);

        $post1 = Post::create([
            'user_id' => $user->id, 
            'title' => 'Основы работы с фреймворком Laravel и базой SQLite',
            'content' => 'Laravel предоставляет мощный ORM Eloquent, позволяющий легко управлять реляционными базами данных, строить сложные связи и применять гибкие Query Scopes.',
            'status' => 'published',
            'views_count' => 15,
        ]);

        $post1->tags()->sync([$tagLaravel->id, $tagPhp->id, $tagArch->id]);

        $post1->comments()->create([
            'body' => 'Отличная статья! Все связи настроены очень наглядно.',
        ]);
        $post1->comments()->create([
            'body' => 'Подскажите, а мягкое удаление тут тоже работает?',
        ]);

        $post2 = Post::create([
            'user_id' => $user->id,
            'title' => 'Продвинутый Frontend и CSS архитектура',
            'content' => 'Черновик будущей публикации про правильную организацию стилей без сторонних тяжелых библиотек.',
            'status' => 'draft',
            'views_count' => 0,
        ]);

        $post2->tags()->sync([$tagFrontend->id]);

        $user->comments()->create([
            'body' => 'Пользователь является проверенным автором статей.',
        ]);
    }
}
