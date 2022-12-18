<?php
 
namespace App\Enums;
 
enum Roles: string
{
    case Student = 'student';
    case Teacher = 'teacher';

    public function getId(): string{
        return match($this) 
        {
            Roles::Student => '1',   
            Roles::Teacher => '2',   
        };
    }
}