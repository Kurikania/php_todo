<?php
enum StatusEnum: int
{
    case TODO = 1;
    case IN_PROGRESS = 2;
    case DONE = 3;
    case CANCELLED = 4;

    public function label(): string
    {
        return match($this) {
            static::TODO => 'Pendiente',
            static::IN_PROGRESS => 'En ejecución',
            static::DONE => 'Hecho',
            static::CANCELLED => 'Canceled by user',
        };
    }
    public static function fromValue(string $value): StatusEnum
    {
        foreach (self::cases() as $status) {
            if( $value == $status->value ){
                return $status;
            }
        }
        throw new \ValueError("$value is not a valid backing value for enum " . self::class );
    }
}