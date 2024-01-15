<?php

enum StorageEnum: string
{
    case MYSQL = MysqlStrategy::class;
    case JSON = JsonStrategy::class;
    case MONGO = MongoStrategy::class;
    public static function fromName(string $value): StorageEnum
    {
        foreach (self::cases() as $case) {
            if( $value == $case->name ){
                return $case;
            }
        }
        throw new \ValueError("$value is not a name backing value for enum " . self::class );
    }
}
