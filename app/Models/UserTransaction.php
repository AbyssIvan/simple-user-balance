<?php

namespace App\Models;

use App\Enum\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class UserTransaction
 * @property int $id
 * @property int $user_id
 * @property TransactionType $type
 * @property float $amount
 * @property int|null $payer_id
 * @property string $comment
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Questionnaire $questionnaire
 * @property-read User|null $payer
 */
class UserTransaction extends Model
{
    protected $table = 'user_transactions';

    protected $fillable = [
        'type',
        'amount',
        'payer_id',
        'comment',
    ];

    /** @inheritdoc */
    protected $casts = ['type' => TransactionType::class];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }
}
