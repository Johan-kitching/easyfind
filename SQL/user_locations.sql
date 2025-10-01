create table user_locations
(
    id                bigint unsigned auto_increment
        primary key,
    user_id           bigint unsigned not null,
    name              varchar(255)    not null,
    address           varchar(255)    null,
    city              varchar(255)    null,
    address_latitude  double          null,
    address_longitude double          null,
    created_at        timestamp       null,
    updated_at        timestamp       null,
    deleted_at        timestamp       null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO user_locations (id, user_id, name, address, city, address_latitude, address_longitude, created_at, updated_at, deleted_at) VALUES (1, 2, '88 Malan Street', '88 Malan Street', 'Pretoria', -25.8080768, 28.3410432, '2024-09-16 05:52:05', '2024-09-16 05:52:05', null);
INSERT INTO user_locations (id, user_id, name, address, city, address_latitude, address_longitude, created_at, updated_at, deleted_at) VALUES (2, 3, 'Stone Arch Estate, Cnr Sunstone &, Brookhill Road, Castleview, Germiston, South Africa', 'Stone Arch Estate, Cnr Sunstone &, Brookhill Road, Castleview, Germiston, South Africa', 'Germiston', -26.255716, 28.167439, '2024-09-16 12:04:26', '2024-09-16 12:04:26', null);
INSERT INTO user_locations (id, user_id, name, address, city, address_latitude, address_longitude, created_at, updated_at, deleted_at) VALUES (3, 4, '88 Malan Street, Schoemansville, Hartbeespoort, South Africa', '88 Malan Street, Schoemansville, Hartbeespoort, South Africa', 'Hartbeespoort', -25.7332776, 27.879623, '2024-10-07 07:50:35', '2024-10-07 07:50:35', null);
INSERT INTO user_locations (id, user_id, name, address, city, address_latitude, address_longitude, created_at, updated_at, deleted_at) VALUES (4, 3, 'Albertina Sisulu Rd, Johannesburg, 2000, South Africa', 'Albertina Sisulu Rd, Johannesburg, 2000, South Africa', 'Johannesburg', -26.205647, 28.0337185, '2024-10-17 12:23:16', '2024-10-17 12:24:04', '2024-10-17 12:24:04');
