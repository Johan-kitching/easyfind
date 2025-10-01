create table pulse_values
(
    id        bigint unsigned auto_increment
        primary key,
    timestamp int unsigned not null,
    type      varchar(255) not null,
    `key`     mediumtext   not null,
    key_hash  binary(16) as (unhex(md5(`key`))),
    value     mediumtext   not null,
    constraint pulse_values_type_key_hash_unique
        unique (type, key_hash)
)
    collate = utf8mb4_unicode_ci;

create index pulse_values_timestamp_index
    on pulse_values (timestamp);

create index pulse_values_type_index
    on pulse_values (type);

INSERT INTO pulse_values (id, timestamp, type, `key`, value) VALUES (1, 1730792022, 'system', 'dedi510jnb2host-hnet', '{"name":"dedi510.jnb2.host-h.net","cpu":21,"memory_used":6724,"memory_total":15703,"storage":[{"directory":"\\/","total":19987,"used":12843}]}');
