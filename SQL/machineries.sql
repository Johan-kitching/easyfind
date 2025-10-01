create table machineries
(
    id                bigint unsigned auto_increment
        primary key,
    machinery_type_id bigint unsigned not null,
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
    constraint machineries_operator_id_foreign
        foreign key (operator_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO machineries (id, machinery_type_id, user_id, operator_id, description, address, city, address_latitude, address_longitude, deleted_at, created_at, updated_at) VALUES (1, 331, 2, null, 'Chery Tractor - Landini MK 10000', '80-90 Malan St, Schoemansville, Hartbeespoort, 0216, South Africa', 'Hartbeespoort', -25.733125, 27.8796828, null, '2024-09-13 09:02:23', '2024-10-10 12:20:43');
INSERT INTO machineries (id, machinery_type_id, user_id, operator_id, description, address, city, address_latitude, address_longitude, deleted_at, created_at, updated_at) VALUES (2, 12, 2, null, '500HP Truck', '80-90 Malan St, Schoemansville, Hartbeespoort, 0216, South Africa', 'Hartbeespoort', -25.733125, 27.8796828, null, '2024-09-13 13:11:43', '2024-10-07 11:35:49');
INSERT INTO machineries (id, machinery_type_id, user_id, operator_id, description, address, city, address_latitude, address_longitude, deleted_at, created_at, updated_at) VALUES (3, 13, 2, null, 'New Bus Available', '80-90 Malan St, Schoemansville, Hartbeespoort, 0216, South Africa', 'Hartbeespoort', -25.733125, 27.8796828, null, '2024-09-16 12:45:21', '2024-10-07 11:35:53');
INSERT INTO machineries (id, machinery_type_id, user_id, operator_id, description, address, city, address_latitude, address_longitude, deleted_at, created_at, updated_at) VALUES (4, 57, 2, null, 'Brand new bus in great condition.', '80-90 Malan St, Schoemansville, Hartbeespoort, 0216, South Africa', 'Hartbeespoort', -25.733125, 27.8796828, null, '2024-10-04 07:50:26', '2024-10-07 11:35:33');
INSERT INTO machineries (id, machinery_type_id, user_id, operator_id, description, address, city, address_latitude, address_longitude, deleted_at, created_at, updated_at) VALUES (5, 331, 1, null, 'USED UD TRUCKS GW26-450 TRUCK TRACTOR/DOUBLE DIFF TRUCK FOR SALE IN PRETORIA GAUTENG.
', 'Eenheids Pl, Derdepoort 326-Jr, Pretoria, 0186, South Africa', 'Pretoria', -25.6949818, 28.29281, null, '2024-10-08 07:07:13', '2024-10-17 12:47:00');
INSERT INTO machineries (id, machinery_type_id, user_id, operator_id, description, address, city, address_latitude, address_longitude, deleted_at, created_at, updated_at) VALUES (6, 5, 3, null, 'Nothing for now', null, null, null, null, null, '2024-10-17 12:40:40', '2024-10-17 12:44:20');
INSERT INTO machineries (id, machinery_type_id, user_id, operator_id, description, address, city, address_latitude, address_longitude, deleted_at, created_at, updated_at) VALUES (7, 108, 3, null, 'Mobile crane', 'Waterberg St, Kosmosdal, Centurion, 0157, South Africa', 'Centurion', -25.914748, 28.1336634, null, '2024-10-17 12:40:48', '2024-10-17 12:47:16');
