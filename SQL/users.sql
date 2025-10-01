create table users
(
    id                        bigint unsigned auto_increment
        primary key,
    name                      varchar(255)                                 null,
    memberName                varchar(255)                                 null,
    email                     varchar(255)                                 not null,
    email_verified_at         timestamp                                    null,
    password                  varchar(255)                                 not null,
    two_factor_secret         text                                         null,
    two_factor_recovery_codes text                                         null,
    remember_token            varchar(100)                                 null,
    current_team_id           bigint unsigned                              null,
    profile_photo_path        varchar(2048)                                null,
    created_at                timestamp                                    null,
    updated_at                timestamp                                    null,
    deleted_at                timestamp                                    null,
    type                      varchar(255)                                 null,
    number                    varchar(255)                                 null,
    companyName               varchar(255)                                 null,
    companyContact            varchar(255)                                 null,
    companyNumber             varchar(255)                                 null,
    website                   varchar(255)                                 null,
    address                   text                                         null,
    status                    enum ('active', 'inactive') default 'active' not null,
    terms                     varchar(255)                                 null,
    constraint users_email_unique
        unique (email)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO users (id, name, memberName, email, email_verified_at, password, two_factor_secret, two_factor_recovery_codes, remember_token, current_team_id, profile_photo_path, created_at, updated_at, deleted_at, type, number, companyName, companyContact, companyNumber, website, address, status, terms) VALUES (1, 'Johan Kitching', 'Johan Kitching', 'johankit@gmail.com', null, '$2y$12$srOvUWwvvAQ24PaJ5oWc7.zAlFv/55pJ5JgQv.mn4Y1ViOdl4Yzt.', null, null, 'PoKnHBXfbGYPVjiWaPiD0Oc90YCJPKxoOsLpBng4yp3DWKe8g1iKNp9jDRLa', null, 'profile-photos/A3mkAPZrPvqlaPy6gkyTPnmLqnD1dcNvVx30a8k5.jpg', '2024-09-13 08:55:19', '2024-10-08 09:23:42', null, 'Company', '0825350520', 'Test Company', 'Pieter', '0125465589', 'google.com', '18038 Jayson Square Apt. 229
Bernhardberg, AK 78589-0748', 'active', 'on');
INSERT INTO users (id, name, memberName, email, email_verified_at, password, two_factor_secret, two_factor_recovery_codes, remember_token, current_team_id, profile_photo_path, created_at, updated_at, deleted_at, type, number, companyName, companyContact, companyNumber, website, address, status, terms) VALUES (2, 'Juan', 'Juan', 'juan@rmwebdevelopers.com', null, '$2y$12$RZ1lTffeEzn2q65ESQ7Tw.nCPEWkRKa584lSnMoBFsgQCVhQVA0PO', null, null, '4ys580poCExAjjUljnpRjqhVA89OShfBd2jgSfmbpsQwXFy2vL0VquQdEBt5', null, null, '2024-09-16 05:52:05', '2024-10-07 06:40:37', null, 'Personal', '0787816136', null, null, null, null, '88 Malan Street', 'active', 'on');
INSERT INTO users (id, name, memberName, email, email_verified_at, password, two_factor_secret, two_factor_recovery_codes, remember_token, current_team_id, profile_photo_path, created_at, updated_at, deleted_at, type, number, companyName, companyContact, companyNumber, website, address, status, terms) VALUES (3, 'Donald', 'Donald', 'macdlnp@gmail.com', null, '$2y$12$.5eg2DFZnFaucLNkeG7Ja.y5x3Lql0.W26BRI7Uk65tzpJpRFX.9e', null, null, 'XZ7rsqUgYBfIPgthUZbbJ7wDUli8PN8iGjL9lZFZ9bLWe3lhCy9rNm89fzyZ', null, null, '2024-09-16 12:04:26', '2024-09-16 12:04:26', null, 'Company', null, 'Awee Plant Hire', 'Donald Mokgohloa', '0732393215', 'macdlnps.co.za', 'Stone Arch Estate, Cnr Sunstone &, Brookhill Road, Castleview, Germiston, South Africa', 'active', 'on');
