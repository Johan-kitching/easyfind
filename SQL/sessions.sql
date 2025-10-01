create table sessions
(
    id            varchar(255)    not null
        primary key,
    user_id       bigint unsigned null,
    ip_address    varchar(45)     null,
    user_agent    text            null,
    payload       longtext        not null,
    last_activity int             not null
)
    collate = utf8mb4_unicode_ci;

create index sessions_last_activity_index
    on sessions (last_activity);

create index sessions_user_id_index
    on sessions (user_id);

INSERT INTO eazyfthpes_db1.sessions (id, user_id, ip_address, user_agent, payload, last_activity) VALUES ('JCqnyyVoh7K8gWcfCu0t6rYYoDKvBR3780JIyJnR', 2, '105.244.93.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWTNZdUJtMFI4dG5kQ0FqTUhJZkdVbjFUMENkaDRVOXpuNmpiZ1p4VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vZWF6eWZpbmRtYWNoaW5lcnlzeXN0ZW0uY28uemEvc2VhcmNoIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFJaMWxUZmZlRXpuMnE2NUVTUTdUdy5uQ1BFV2tSS2E1ODRsU25Nb0JGc2dRQ1ZoUVZBMFBPIjt9', 1730791736);
INSERT INTO eazyfthpes_db1.sessions (id, user_id, ip_address, user_agent, payload, last_activity) VALUES ('QyxQ3f7EE2LFQWnMyDEVvRh66ParlkSTYmvY3xMr', 1, '197.184.178.34', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoidGdra0k0dTdIVTFIb0kwQ0dJUjNNYjRDenhmc0tIMHJ2b0pwbEpnTSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwczovL2VhenlmaW5kbWFjaGluZXJ5c3lzdGVtLmNvLnphIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJHNyT3ZVV3d2dkFRMjRQYUo1b1djNy56QWxGdi81NXBKNUpnUXYubW40WTFWaU9kbDRZenQuIjtzOjMxOiJsb2ctdmlld2VyOnNob3J0ZXItc3RhY2stdHJhY2VzIjtiOjA7fQ==', 1730730559);
