<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StaffSettings extends Settings
{
    public int $student_money;

    public int $staff_money;

    public int $membership_fee_staff;

    public int $salary_ass;

    public int $salary_ass_f;

    public int $salary_ins_f;

    public int $salary_ins;

    public int $salary_ins_aldre;

    public int $salary_bkc;

    public int $salary_kc;

    public int $salary_b_ass;

    public int $salary_b_ins;

    public int $salary_b_ins_aldre;

    public int $salary_bbc;

    public int $salary_bc;

    public int $salary_us;

    public int $salary_bsc;

    public int $salary_sc;

    public int $salary_mat_ass;

    public int $salary_mat_ins;

    public int $salary_mat_ins_aldre;

    public static function group(): string
    {
        return 'staff';
    }
}
