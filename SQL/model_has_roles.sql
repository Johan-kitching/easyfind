create table model_has_roles
(
    role_id    bigint unsigned not null,
    model_type varchar(255)    not null,
    model_id   bigint unsigned not null,
    primary key (role_id, model_id, model_type),
    constraint model_has_roles_role_id_foreign
        foreign key (role_id) references roles (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index model_has_roles_model_id_model_type_index
    on model_has_roles (model_id, model_type);

INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (1, 'App\\Models\\User', 1);
INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (1, 'App\\Models\\User', 2);
INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (1, 'App\\Models\\User', 3);
INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (1, 'App\\Models\\User', 4);
