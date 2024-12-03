create database sekolah;

create table sekolah.siswa(
  id VARCHAR(255) PRIMARY KEY,
  id_kelas VARCHAR(255),
  nama VARCHAR(255) not null,
  umur int(11) not null
);

create table sekolah.kelas(
  id VARCHAR(255) PRIMARY KEY,
  nama VARCHAR(255) not null
);

alter table sekolah.siswa
add FOREIGN KEY(id_kelas) REFERENCES sekolah.kelas(id);


