<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;

class NewsPolicy
{
    public function before(User $user): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function create(User $user): bool
    {
        return $user->role === 'journalist';
    }

    public function update(User $user, News $news): bool
    {
        return $user->id === $news->author_id;
    }

    public function delete(User $user, News $news): bool
    {
        return $user->id === $news->author_id;
    }
}
