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

    public function color(): string
    {
        return match($this) {
            static::TODO => 'bg-red-200',
            static::IN_PROGRESS => 'bg-yellow-200',
            static::DONE => 'bg-green-200',
            static::CANCELLED => 'bg-gray-200',
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