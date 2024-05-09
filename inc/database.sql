drop table if exists patient_medication;
drop table if exists patients;
drop table if exists doctors;
drop table if exists medications;


create table doctors
(
    id         int auto_increment
        primary key,
    name       varchar(255)                       not null,
    created_at datetime default (now())           not null,
    updated_at datetime default CURRENT_TIMESTAMP not null,
    deleted_at datetime                           null
);

create table medications
(
    id         int auto_increment
        primary key,
    name       varchar(255)             not null,
    dose       varchar(255)             not null,
    created_at datetime default (now()) null,
    updated_at datetime default (now()) null,
    deleted_at datetime                 null
);

create table patients
(
    id         int                                not null
        primary key,
    name       varchar(255)                       not null,
    doctor_id  int                                null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime default CURRENT_TIMESTAMP not null,
    deleted_at datetime                           null,
    constraint patients_doctors_id_fk
        foreign key (doctor_id) references doctors (id)
);

create table patient_medication
(
    id              int auto_increment
        primary key,
    patient_id      int                      not null,
    medication_id   int                      not null,
    quantity        int                      not null,
    frequency_hours int                      not null,
    created_at      datetime default (now()) null,
    updated_at      datetime default (now()) null,
    deleted_at      datetime                 null,
    start_by        date                     not null,
    end_by          date                     not null,
    constraint patient_medication_medications_id_fk
        foreign key (medication_id) references medications (id)
            on delete cascade,
    constraint patient_medication_patients_id_fk
        foreign key (patient_id) references patients (id)
            on delete cascade
);

create index patient_medication_medication_id_index
    on patient_medication (medication_id);

create index patient_medication_patient_id_index
    on patient_medication (patient_id);

create index patients_doctor_id_index
    on patients (doctor_id);

