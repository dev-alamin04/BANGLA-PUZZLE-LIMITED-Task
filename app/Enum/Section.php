<?php

namespace App\Enum;

enum Section: string
{
    // home page
    case HERO_SECTION = 'hero_section';
    case SERVICES_SECTION = 'services_section';
    case WORK_SECTION = 'work_section';
    case SUB_FOOTER_SECTION = 'sub_footer_section';
    case FOOTER_SECTION = 'footer_section';

    case ABOUT_SECTION = 'about_section';

    case FAQ_SECTION = 'faq_section';

    case CONTACT_SECTION = 'contact_section';

    case SHOP_SECTION = 'shop_section';
    case BANNER_SECTION = 'banner_section';
}
