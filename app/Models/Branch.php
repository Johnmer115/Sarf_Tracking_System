<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'location', 'code'];

    private static function generateCode($department): string
    {
        $branch = Branch::find($department->branch_id);

        // fallback if no branch found
        $branchCode = $branch?->code ?? 'BR';

        // get department initials
        $words = explode(' ', $department->name);

        $initials = '';
        foreach ($words as $word) {
            if ($word !== '') {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        // base format: AU-BRANCHCODE-DEPT
        $baseCode = 'AU-'.$branchCode.'-'.$initials;

        $code = $baseCode;
        $suffix = 2;

        // ensure uniqueness
        while (self::query()->where('code', $code)->exists()) {
            $code = $baseCode.'-'.$suffix;
            $suffix++;
        }

        return $code;
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
