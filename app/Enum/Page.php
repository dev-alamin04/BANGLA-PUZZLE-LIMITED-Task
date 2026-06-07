<?php

namespace App\Enum;

enum Page: string
{

    case SPLASH = 'splash';
    case LOGIN = 'login';
    case SIGNUP = 'signup';
    case FORGOT_PASSWORD = 'forgot-password';
    case OTP_VERIFICATION = 'otp-verification';
    case NEW_PASSWORD = 'new-password';
    case HOME = 'home';
    case ABOUT = 'about';
    case SERVICES = 'services';
    case PROJECTS = 'projects';
    case FAQ = 'faq';
    case SHOP = 'shop';
    case CONTACT = 'contact';
}
