create table equipment
(
    id                bigint unsigned auto_increment
        primary key,
    equipment_type_id bigint unsigned not null,
    user_id           bigint unsigned not null,
    operator_id       bigint unsigned null,
    description       longtext        null,
    address           varchar(255)    null,
    city              varchar(255)    null,
    address_latitude  double          null,
    address_longitude double          null,
    deleted_at        timestamp       null,
    created_at        timestamp       null,
    updated_at        timestamp       null,
    constraint equipment_operator_id_foreign
        foreign key (operator_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

