<?php

namespace App\Http\Controllers\Web;

use App\ContactType;
use App\Http\Controllers\Controller;

class ContactTypeController extends Controller
{
      public function all()
    {
        $contactTypes = ContactType::all();
        return $contactTypes;
    }
}
