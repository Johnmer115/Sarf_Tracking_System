<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'branch_id', 'code', 'dept_dean'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($department) {
            $department->code = self::generateCode($department);
        });

        static::updating(function ($department) {
            if ($department->isDirty(['name', 'branch_id'])) {
                $department->code = self::generateCode($department, $department->id);
            }
        });
    }

    private static function generateCode(self $department, ?int $ignoreId = null): string
    {
        $branch = Branch::find($department->branch_id);
        $branchCode = $branch?->code ?? 'AU-BR';

        $words = explode(' ', $department->name);

        $initials = '';
        foreach ($words as $word) {
            if ($word !== '') {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        $departmentCode = $initials !== '' ? $initials : 'DEPT';
        $baseCode = $branchCode.'-'.$departmentCode;
        $code = $baseCode;
        $suffix = 2;

        while (
            self::query()
                ->when($ignoreId !== null, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('code', $code)
                ->exists()
        ) {
            $code = $baseCode.'-'.$suffix;
            $suffix++;
        }

        return $code;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
}
