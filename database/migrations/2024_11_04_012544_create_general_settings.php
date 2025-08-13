<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('staff.student_money', '35');
        $this->migrator->add('staff.staff_money', '150');
        $this->migrator->add('public.membership_fee', '500');
        $this->migrator->add('public.registration_fee', '1300');
        $this->migrator->add('staff.membership_fee_staff', '200');
        $this->migrator->add('public.camps_message', 'Lediga platser uppdateras automatiskt och det är först till kvarn, vi har ingen kölista. Byte av läger görs enklast på mina sidor. Välkomma!');
        $this->migrator->add('public.registration_confirmed_message', null);
        $this->migrator->add('admin.export_password', 'julle');
        $this->migrator->add('staff.salary_ass', '1500');
        $this->migrator->add('staff.salary_ass_f', '2500');
        $this->migrator->add('staff.salary_ins_f', '3000');
        $this->migrator->add('staff.salary_ins', '2500');
        $this->migrator->add('staff.salary_ins_aldre', '3000');
        $this->migrator->add('staff.salary_bkc', '4750');
        $this->migrator->add('staff.salary_kc', '5750');
        $this->migrator->add('staff.salary_b_ass', '1500');
        $this->migrator->add('staff.salary_b_ins', '2500');
        $this->migrator->add('staff.salary_b_ins_aldre', '3000');
        $this->migrator->add('staff.salary_bbc', '4750');
        $this->migrator->add('staff.salary_bc', '5750');
        $this->migrator->add('staff.salary_us', '4750');
        $this->migrator->add('staff.salary_bsc', '4750');
        $this->migrator->add('staff.salary_sc', '6750');
        $this->migrator->add('staff.salary_mat_ass', '1500');
        $this->migrator->add('staff.salary_mat_ins', '2500');
        $this->migrator->add('staff.salary_mat_ins_aldre', '3000');
    }
};
