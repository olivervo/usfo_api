<?php

namespace App\Enums;

enum StaffRoles
{
    case ass;
    case ass_f;
    case ins;
    case ins_aldre;
    case bkc;
    case ins_f;
    case kc;
    case bat_ass;
    case bat_ins;
    case bat_ins_aldre;
    case bbc;
    case bc;
    case us;
    case bsc;
    case sc;
    case mat_ass;
    case mat_ins;
    case mat_ins_aldre;
    case mc;

    public function label(): string
    {
        return match ($this) {
            self::ass => 'Assistent',
            self::ass_f => 'Assistent fortsättning',
            self::ins => 'Instruktör',
            self::ins_aldre => 'Instruktör äldre',
            self::bkc => 'Bitr kurschef',
            self::ins_f => 'Instruktör fortsättning',
            self::kc => 'Kurschef',
            self::bat_ass => 'Båtassistent',
            self::bat_ins => 'Båtinstruktör',
            self::bat_ins_aldre => 'Båtinstruktör äldre',
            self::bbc => 'Bitr båtchef',
            self::bc => 'Båtchef',
            self::us => 'Upplärning skolchef',
            self::bsc => 'Bitr skolchef',
            self::sc => 'Skolchef',
            self::mat_ass => 'Matassistent',
            self::mat_ins => 'Matinstruktör',
            self::mat_ins_aldre => 'Matinstruktör äldre',
            self::mc => 'Matchef',
        };
    }
}
