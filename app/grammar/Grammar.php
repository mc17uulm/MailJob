<?php

namespace app\grammar;

class Grammar
{

    public static function beautify (Person $person, Casus $casus = null, string $verb = null) : string
    {
        $casus = is_null($casus) ? Casus::NOMINATIV() : $casus;
        return is_null($verb) ? self::beautify_person($person, $casus) : self::beautify_word($person, $verb, $casus);
    }

    private static function beautify_person(Person $person, Casus $casus) : string
    {
        switch($casus)
        {
            case Casus::NOMINATIV(): return self::person_get_nominativ($person);
            case Casus::AKKUSATIV(): return self::person_get_akkusativ($person);
            case Casus::DATIV(): return self::person_get_dativ($person);
            case Casus::GENITIV(): return self::person_get_genitiv($person);
        }
    }

    private static function beautify_word(Person $person, string $verb, Casus $casus) : string
    {
        return "";
    }

    private static function person_get_nominativ(Person $person) : string
    {
        switch($person->get_type())
        {

            case 1: return $person->is_plural() ? "wir" : "ich";
            case 2: return $person->is_plural() ? "ihr" : "du";
            case 3: return $person->is_plural() ? "sie" : ($person->is_female() ? "sie" : "er");
            default: return "-- word not found --";
                
        }
    }

    private static function person_get_akkusativ(Person $person) : string
    {
        switch($person->get_type())
        {

            case 1: return $person->is_plural() ? "uns": "mich";
            case 2: return $person->is_plural() ? "euch" : "dich";
            case 3: return $person->is_plural() ? "sie" : ($person->is_female() ? "sie" : "ihn");
            default: return "-- word not found --";

        }
    }

    private static function person_get_dativ(Person $person) : string
    {
        switch($person->get_type())
        {

            case 1: return $person->is_plural() ? "uns": "mir";
            case 2: return $person->is_plural() ? "euch" : "dir";
            case 3: return $person->is_plural() ? "ihnen" : ($person->is_female() ? "ihr" : "ihm");
            default: return "-- word not found --";

        }
    }

    private static function person_get_genitiv(Person $person) : string
    {
        switch($person->get_type())
        {

            case 1: return $person->is_plural() ? "unser": "meiner";
            case 2: return $person->is_plural() ? "euer" : "deiner";
            case 3: return $person->is_plural() ? "ihrer" : ($person->is_female() ? "ihrer" : "seiner");
            default: return "-- word not found --";

        }
    }

}