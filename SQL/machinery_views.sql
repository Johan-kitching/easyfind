create table machinery_views
(
    id           bigint unsigned auto_increment
        primary key,
    machinery_id bigint unsigned not null,
    user_agent   varchar(255)    not null,
    ip           varchar(45)     not null,
    created_at   timestamp       null,
    updated_at   timestamp       null,
    constraint machinery_views_machinery_id_foreign
        foreign key (machinery_id) references machineries (id)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (1, 5, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '197.184.177.25', '2024-10-08 10:41:08', '2024-10-08 10:41:08');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (2, 1, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '197.184.177.25', '2024-10-08 10:42:32', '2024-10-08 10:42:32');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (3, 2, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '197.184.177.25', '2024-10-08 10:43:09', '2024-10-08 10:43:09');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (4, 3, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '197.184.177.25', '2024-10-08 10:43:18', '2024-10-08 10:43:18');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (5, 4, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '197.184.177.25', '2024-10-08 10:43:21', '2024-10-08 10:43:21');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (6, 5, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '41.216.202.5', '2024-10-09 14:50:43', '2024-10-09 14:50:43');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (7, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '105.244.81.114', '2024-10-09 14:51:42', '2024-10-09 14:51:42');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (8, 1, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '41.216.202.5', '2024-10-09 14:51:50', '2024-10-09 14:51:50');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (9, 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '105.244.81.114', '2024-10-09 14:51:58', '2024-10-09 14:51:58');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (10, 2, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '41.216.202.5', '2024-10-09 14:52:02', '2024-10-09 14:52:02');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (11, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '105.244.81.114', '2024-10-10 09:27:46', '2024-10-10 09:27:46');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (12, 3, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '41.216.202.5', '2024-10-10 12:19:55', '2024-10-10 12:19:55');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (13, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '105.245.102.225', '2024-10-17 12:25:48', '2024-10-17 12:25:48');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (14, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '105.245.102.225', '2024-10-17 12:25:59', '2024-10-17 12:25:59');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (15, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '105.245.102.225', '2024-10-17 12:26:04', '2024-10-17 12:26:04');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (16, 1, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36', '41.121.23.251', '2024-10-17 12:37:44', '2024-10-17 12:37:44');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (19, 7, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '105.244.84.200', '2024-10-17 12:54:44', '2024-10-17 12:54:44');
INSERT INTO machinery_views (id, machinery_id, user_agent, ip, created_at, updated_at) VALUES (20, 7, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '197.184.183.154', '2024-10-17 12:55:06', '2024-10-17 12:55:06');
