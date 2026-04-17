<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    //
    protected $fillable = ['name', 'account_id', 'department_id', 'code'];

     protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($organization) {
            $organization->code = self::generateCode($organization);
        });

        static::updating(function ($organization) {
            if ($organization->isDirty(['name', 'department_id'])) {
                $organization->code = self::generateCode($organization, $organization->id);
            }
        });
    }

    private static function generateCode(self $organization, ?int $ignoreId = null): string
    {
        // 🔗 Get Department
        $department = Department::find($organization->department_id);


        // Safe fallbacks
        $departmentCode = $department?->code ?? 'DEPT';

        // 🔤 Organization initials
        $words = explode(' ', $organization->name);

        $initials = '';
        foreach ($words as $word) {
            if ($word !== '') {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        $orgCode = $initials !== '' ? $initials : 'ORG';

        // 🔥 Final format
        $baseCode =  $departmentCode . '-' . $orgCode;

        $code = $baseCode;
        $suffix = 2;

        // 🔁 Ensure uniqueness
        while (
            self::query()
                ->when($ignoreId !== null, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('code', $code)
                ->exists()
        ) {
            $code = $baseCode . '-' . $suffix;
            $suffix++;
        }

        return $code;
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
