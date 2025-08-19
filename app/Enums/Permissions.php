<?php

namespace App\Enums;

enum Permissions
{
    case UsersView;
    case UsersCreate;
    case UsersUpdate;
    case UsersDelete;

    case RolesView;
    case RolesCreate;
    case RolesUpdate;
    case RolesDelete;

    case BookingsView;
    case BookingsCreate;
    case BookingsUpdate;
    case BookingsDelete;

    case PaymentsView;
    case PaymentsCreate;
    case PaymentsUpdate;
    case PaymentsDelete;
    case PaymentsProcess;
    case PaymentsRefund;

    case LodgesView;
    case LodgesCreate;
    case LodgesUpdate;
    case LodgesDelete;

    case RoomsView;
    case RoomsCreate;
    case RoomsUpdate;
    case RoomsDelete;

    case CampsitesView;
    case CampsitesCreate;
    case CampsitesUpdate;
    case CampsitesDelete;

    case MooringsView;
    case MooringsCreate;
    case MooringsUpdate;
    case MooringsDelete;

    case RegistrationsView;
    case RegistrationsCreate;
    case RegistrationsUpdate;
    case RegistrationsDelete;

    case CampsView;
    case CampsCreate;
    case CampsUpdate;
    case CampsDelete;

    case StaffView;
    case StaffCreate;
    case StaffUpdate;
    case StaffDelete;

    case StudentsView;
    case StudentsCreate;
    case StudentsUpdate;
    case StudentsDelete;

    case MembershipsView;
    case MembershipsCreate;
    case MembershipsUpdate;
    case MembershipsDelete;

}
