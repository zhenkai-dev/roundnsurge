<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Event
 *
 * @property int $id
 * @property \Carbon\Carbon $event_start_at
 * @property \Carbon\Carbon $event_end_at
 * @property string $rsvp_link
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Event onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereRsvpLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Event withoutTrashed()
 * @mixin \Eloquent
 */
class Event extends Model
{
    use SoftDeletes;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $dates = [
        'event_start_at',
        'event_end_at'
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'events';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getEventStartAt(): \Carbon\Carbon
    {
        return $this->event_start_at;
    }

    /**
     * @param \Carbon\Carbon $event_start_at
     */
    public function setEventStartAt(\Carbon\Carbon $event_start_at): void
    {
        $this->event_start_at = $event_start_at;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getEventEndAt(): \Carbon\Carbon
    {
        return $this->event_end_at;
    }

    /**
     * @param \Carbon\Carbon $event_end_at
     */
    public function setEventEndAt(\Carbon\Carbon $event_end_at): void
    {
        $this->event_end_at = $event_end_at;
    }

    /**
     * @return string
     */
    public function getRsvpLink(): string
    {
        return $this->rsvp_link;
    }

    /**
     * @param string $rsvp_link
     */
    public function setRsvpLink(string $rsvp_link): void
    {
        $this->rsvp_link = $rsvp_link;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return null|string
     */
    public function getDeletedAt(): ?string
    {
        return $this->deleted_at;
    }

    /**
     * @param null|string $deleted_at
     */
    public function setDeletedAt(?string $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getCreatedAt(): ?\Carbon\Carbon
    {
        return $this->created_at;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getUpdatedAt(): ?\Carbon\Carbon
    {
        return $this->updated_at;
    }

    /**
     * @param string $lang
     * @return HasOne
     */
    public function eventTranslation(string $lang = ''): HasOne
    {
        if (empty($lang)) {
            $lang = app('Language')->getId();
        }

        return $this->hasOne('App\EventTranslation', 'event_id', 'id')
            ->where('language_id', $lang);
    }

    /**
     * Get friendly url
     *
     * @return MorphMany
     */
    /*public function friendlyUrl(): MorphMany
    {
        return $this->morphMany('App\FriendlyUrl', 'name', 'module', 'fkid');
    }*/
}
