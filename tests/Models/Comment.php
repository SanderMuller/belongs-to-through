<?php

namespace Tests\Models;

use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\HasTableAlias;

/**
 * @property int $id
 *
 * @property-read \Tests\Models\Country|null $country
 */
class Comment extends Model
{
    use HasTableAlias;

    /**
     * @return \Znck\Eloquent\Relations\BelongsToThrough<\Tests\Models\Country, \Tests\Models\User|\Tests\Models\Post, $this>
     */
    public function country(): BelongsToThrough
    {
        return $this->belongsToThrough(Country::class, [User::class, Post::class])->withDefault();
    }

    /**
     * @return \Znck\Eloquent\Relations\BelongsToThrough<\Tests\Models\Country, \Tests\Models\User|\Tests\Models\Post, $this>
     */
    public function countryWithCustomForeignKeys(): BelongsToThrough
    {
        return $this->belongsToThrough(
            Country::class,
            [[User::class, 'custom_user_id'], Post::class],
            null,
            '',
            [Post::class => 'custom_post_id']
        );
    }

    /**
     * @return \Znck\Eloquent\Relations\BelongsToThrough<\Tests\Models\Country, \Tests\Models\User|\Tests\Models\Post, $this>
     */
    public function countryWithTrashedUser(): BelongsToThrough
    {
        /* @phpstan-ignore return.type */
        return $this->country()->withTrashed(['users.deleted_at']);
    }

    /**
     * @return \Znck\Eloquent\Relations\BelongsToThrough<\Tests\Models\Country, \Tests\Models\User|\Tests\Models\Post, $this>
     */
    public function countryWithPrefix(): BelongsToThrough
    {
        return $this->belongsToThrough(Country::class, [User::class, Post::class], null, 'custom_');
    }

    /**
     * @return \Znck\Eloquent\Relations\BelongsToThrough<self, self, $this>
     */
    public function grandparent(): BelongsToThrough
    {
        /* @phpstan-ignore argument.templateType, argument.type, return.type */
        return $this->belongsToThrough(self::class, self::class.' as alias', null, '', [self::class => 'parent_id']);
    }

    /**
     * @return \Znck\Eloquent\Relations\BelongsToThrough<\Tests\Models\User, \Tests\Models\Post, $this>
     */
    public function user(): BelongsToThrough
    {
        return $this->belongsToThrough(User::class, Post::class);
    }
}
