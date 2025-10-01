create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO migrations (id, migration, batch) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (4, '2024_07_11_155601_create_pulse_tables', 1);
INSERT INTO migrations (id, migration, batch) VALUES (5, '2024_07_11_155714_add_two_factor_columns_to_users_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (6, '2024_07_11_155735_create_personal_access_tokens_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (7, '2024_07_15_134512_codes_and_descriptions', 1);
INSERT INTO migrations (id, migration, batch) VALUES (8, '2024_07_18_063145_users_update', 1);
INSERT INTO migrations (id, migration, batch) VALUES (9, '2024_07_25_124927_users_location_details', 1);
INSERT INTO migrations (id, migration, batch) VALUES (10, '2024_07_29_125327_create_permission_tables', 1);
INSERT INTO migrations (id, migration, batch) VALUES (11, '2024_08_07_090329_create_equipment_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (12, '2024_08_07_090329_create_machinery_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (13, '2024_08_12_113003_create_files_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (14, '2024_08_12_153525_create_activity_log_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (15, '2024_08_12_153526_add_event_column_to_activity_log_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (16, '2024_08_12_153527_add_batch_uuid_column_to_activity_log_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (17, '2024_09_03_105805_create_machinery_types_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (18, '2024_09_03_105912_create_equipment_types_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (19, '2024_09_04_120952_machinery_table_update', 1);
INSERT INTO migrations (id, migration, batch) VALUES (20, '2024_09_13_091310_users_table_update', 2);
INSERT INTO migrations (id, migration, batch) VALUES (21, '2024_09_16_100928_create_machinery_availabilities_table', 3);
INSERT INTO migrations (id, migration, batch) VALUES (23, '2024_10_08_100246_create_machinery_views_table', 4);
INSERT INTO migrations (id, migration, batch) VALUES (24, '2024_11_04_092820_create_mechanics_table', 5);
INSERT INTO migrations (id, migration, batch) VALUES (25, '2024_10_08_100246_create_mechanic_views_table', 6);
INSERT INTO migrations (id, migration, batch) VALUES (27, '2024_11_04_133640_mechanic', 7);
