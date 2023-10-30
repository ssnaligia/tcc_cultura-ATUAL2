CREATE TABLE TipoPerfil (
    id_tipo INT AUTO_INCREMENT,
    nome_tipo VARCHAR(20) NOT NULL,
    PRIMARY KEY (id_tipo)
);

INSERT INTO TipoPerfil (nome_tipo) VALUES ("Administrador");
INSERT INTO TipoPerfil (nome_tipo) VALUES ("Usuário");

CREATE TABLE VerificacaoEmail (
    id_confirmaEmail INT AUTO_INCREMENT,
    nome_situacao VARCHAR(45),
    PRIMARY KEY (id_confirmaEmail)
);

INSERT INTO VerificacaoEmail (nome_situacao) VALUES ("Ativo");
INSERT INTO VerificacaoEmail (nome_situacao) VALUES ("Inativo");
INSERT INTO VerificacaoEmail (nome_situacao) VALUES ("Aguardando Confirmação");

CREATE TABLE Cadastro (
    nome VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(30),
    data_nasc DATE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    chave VARCHAR(255),
    id_confirmaEmail INT NOT NULL DEFAULT 3,
    primeiroLogin BOOLEAN DEFAULT TRUE,
    id_tipo INT,
    PRIMARY KEY (email),
    FOREIGN KEY (id_tipo) REFERENCES TipoPerfil (id_tipo),
    FOREIGN KEY (id_confirmaEmail) REFERENCES VerificacaoEmail (id_confirmaEmail)
);

INSERT INTO Cadastro (nome, email, telefone, data_nasc, senha, chave, id_confirmaEmail, primeiroLogin, id_tipo) VALUES ("ADM", "adm.ofc.arq@gmail.com", "16988508074", "2004-01-01", "29bcc666111c0eee52bf5758c4d65d2f", "chavee29bcc666111c0eee52bf5758c4d65d2f", 1, FALSE, 1);

CREATE TABLE Categoria (
    id_categoria INT AUTO_INCREMENT,
    nome_categoria VARCHAR(30) NOT NULL,
    PRIMARY KEY (id_categoria)
);

INSERT INTO Categoria (nome_categoria) VALUES ("Eventos no Geral");
INSERT INTO Categoria (nome_categoria) VALUES ("Teatro");
INSERT INTO Categoria (nome_categoria) VALUES ("Dança");
INSERT INTO Categoria (nome_categoria) VALUES ("Literatura");
INSERT INTO Categoria (nome_categoria) VALUES ("Música");
INSERT INTO Categoria (nome_categoria) VALUES ("Política");
INSERT INTO Categoria (nome_categoria) VALUES ("Esporte");
INSERT INTO Categoria (nome_categoria) VALUES ("Manifestações Religiosas");
INSERT INTO Categoria (nome_categoria) VALUES ("Entretenimento/Cinema");
INSERT INTO Categoria (nome_categoria) VALUES ("Shows");
INSERT INTO Categoria (nome_categoria) VALUES ("Debates");

CREATE TABLE Preferencias (
    id_preferencias INT AUTO_INCREMENT,
    email VARCHAR(100),
    categoria INT,
    PRIMARY KEY (id_preferencias, email),
    FOREIGN KEY (email) REFERENCES Cadastro (email) ON DELETE CASCADE,
    FOREIGN KEY (categoria) REFERENCES Categoria (id_categoria)
);


CREATE TABLE Comentarios (
  id_comentario INT AUTO_INCREMENT,
  id_ponto INT, 
  comentario TEXT,
  data_publicacao DATETIME,
  email VARCHAR(100),
  PRIMARY KEY (id_comentario, email),
  FOREIGN KEY (id_ponto) REFERENCES PontosCulturais (id_ponto) ON DELETE CASCADE,
  FOREIGN KEY (email) REFERENCES Cadastro (email) ON DELETE CASCADE
);

CREATE TABLE PontosCulturais (
    id_ponto INT AUTO_INCREMENT PRIMARY KEY,
    criador VARCHAR(100),
    nome_ponto VARCHAR(100) NULL UNIQUE,
    endereco VARCHAR(100),
    categoria INT,
    descricao LONGTEXT,
    aprovado TINYINT DEFAULT 0, /* 0 não aprovado, 1 aprovado */
    FOREIGN KEY (categoria) REFERENCES Categoria (id_categoria),
    FOREIGN KEY (criador) REFERENCES Cadastro (email)
);

CREATE TABLE Imagens (
  id_ponto INT,
  diretorio_imagem VARCHAR(255),
  FOREIGN KEY (id_ponto) REFERENCES PontosCulturais (id_ponto) ON DELETE CASCADE
);

CREATE TABLE Eventos (
    id_ponto INT,
    criador VARCHAR(100),
    id_evento INT AUTO_INCREMENT,
    nome_evento VARCHAR(100) NULL UNIQUE,
    descricao_evento VARCHAR(100),
    categoria INT,
    data_evento DATE NOT NULL,
    horario TIME NOT NULL,
    aprovado TINYINT DEFAULT 0, /* 0 não aprovado, 1 aprovado */
    PRIMARY KEY (id_evento),
    FOREIGN KEY (id_ponto) REFERENCES PontosCulturais (id_ponto) ON DELETE CASCADE,
    FOREIGN KEY (categoria) REFERENCES Categoria (id_categoria),
    FOREIGN KEY (criador) REFERENCES Cadastro (email)
);

CREATE TABLE EscolhasUsuario (
    id_escolha INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    id_evento INT,
    escolha VARCHAR(20),
    FOREIGN KEY (email) REFERENCES Cadastro (email) ON DELETE CASCADE,
    FOREIGN KEY (id_evento) REFERENCES Eventos(id_evento)
);

CREATE TABLE Avaliacoes (
    id_ponto INT,
    id_avaliacao INT AUTO_INCREMENT,
    qnt_estrela INT,
    criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_avaliacao),
    FOREIGN KEY (id_ponto) REFERENCES PontosCulturais (id_ponto) ON DELETE CASCADE
);

CREATE TABLE Comunidade (
    id_comunidade INT AUTO_INCREMENT,
    criador VARCHAR(100),
    nome_comunidade VARCHAR(100) NULL UNIQUE,
    idade_minima VARCHAR(20),
    descricao_comunidade LONGTEXT,
    aprovado TINYINT DEFAULT 0, /* 0 não aprovado, 1 aprovado */
    PRIMARY KEY (id_comunidade),
    FOREIGN KEY (criador) REFERENCES Cadastro (email)
);

CREATE TABLE usuarioComunidade (
    id INT AUTO_INCREMENT,
    email VARCHAR(100),
    id_comunidade INT,
    PRIMARY KEY (id),
    FOREIGN KEY (email) REFERENCES Cadastro (email) ON DELETE CASCADE,
    FOREIGN KEY (id_comunidade) REFERENCES Comunidade (id_comunidade)
);

CREATE TABLE Chat (
    id_chat INT AUTO_INCREMENT,
    id_comunidade INT,
    email VARCHAR(100) NOT NULL,
    mensagens LONGTEXT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_chat),
    FOREIGN KEY (email) REFERENCES Cadastro (email) ON DELETE CASCADE,
    FOREIGN KEY (id_comunidade) REFERENCES Comunidade (id_comunidade)
);

CREATE TABLE Notificacoes (
    email VARCHAR(100) NOT NULL,
    notificacao VARCHAR(100) NOT NULL,
    PRIMARY KEY (email),
    FOREIGN KEY (email) REFERENCES Cadastro (email)
);

CREATE TABLE Coordenadas (
    id_ponto INT PRIMARY KEY,
    latitude FLOAT( 10, 6 ) NOT NULL,
    longitude FLOAT ( 10, 6 ) NOT NULL,
    FOREIGN KEY (id_ponto) REFERENCES PontosCulturais (id_ponto) ON DELETE CASCADE
);

CREATE TABLE markers (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL,
    address VARCHAR(80) NOT NULL,
    lat FLOAT( 10, 6 ) NOT NULL,
    lng FLOAT ( 10, 6 ) NOT NULL,
    type VARCHAR(30) NOT NULL 
) ENGINE = MYISAM;
