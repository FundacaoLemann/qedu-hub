<?php

namespace Tests\Fixture\Database;

class SchoolCensusTableFixture extends ProvaBrasilDatabase
{
    public function createTable($kernel)
    {
        $this->createDatabase($kernel);

        $this->loadEntityManager($kernel);

        $this->createSchoolCensusTable();
    }

    public function createSchoolCensusTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `school_educacenso` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` tinyint(3) unsigned NOT NULL,
  `city_id` smallint(5) unsigned NOT NULL,
  `school_id` mediumint(8) unsigned NOT NULL,
  `educacenso` smallint(5) unsigned NOT NULL,
  `prova_brasil` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `educacao_basica` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cadastro_fax` int(11) DEFAULT NULL ,
  `cadastro_telefone_publico_2` int(11) DEFAULT NULL ,
  `acessibilidade_escola` tinyint(1) unsigned DEFAULT NULL ,
  `acessibilidade_dependencias` tinyint(1) unsigned DEFAULT NULL ,
  `acessibilidade_sanitario` tinyint(1) unsigned DEFAULT NULL ,
  `alimentacao_fornecida` tinyint(1) unsigned DEFAULT NULL ,
  `alimentacao_agua_filtrada` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_sanitario_dentro_predio` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_sanitario_fora_predio` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_biblioteca` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_cozinha` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_lab_informatica` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_lab_ciencias` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_sala_leitura` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_quadra_esportes` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_sala_diretora` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_sala_professores` tinyint(1) unsigned DEFAULT NULL ,
  `dependencias_sala_atendimento_especial` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_agua_rede_publica` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_agua_poco_artesiano` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_agua_cacimba` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_agua_fonte_rio` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_agua_inexistente` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_energia_rede_publica` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_energia_gerador` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_energia_outros` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_energia_inexistente` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_esgoto_rede_publica` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_esgoto_fossa` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_esgoto_inexistente` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_lixo_coleta_periodica` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_lixo_queima` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_lixo_joga_outra_area` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_lixo_recicla` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_lixo_enterra` tinyint(1) unsigned DEFAULT NULL ,
  `servicos_lixo_outros` tinyint(1) unsigned DEFAULT NULL ,
  `tecnologia_internet` tinyint(1) unsigned DEFAULT NULL ,
  `tecnologia_banda_larga` tinyint(1) unsigned DEFAULT NULL ,
  `tecnologia_computadores_alunos` smallint(4) unsigned DEFAULT NULL ,
  `tecnologia_computadores_administrativos` smallint(4) unsigned DEFAULT NULL ,
  `equipamento_dvd` tinyint(1) unsigned DEFAULT NULL ,
  `equipamento_impressora` tinyint(1) unsigned DEFAULT NULL ,
  `equipamento_parabolica` tinyint(1) unsigned DEFAULT NULL ,
  `equipamento_copiadora` tinyint(1) unsigned DEFAULT NULL ,
  `equipamento_retroprojetor` tinyint(1) unsigned DEFAULT NULL ,
  `equipamento_tv` tinyint(1) unsigned DEFAULT NULL ,
  `outros_num_funcionarios` smallint(4) unsigned DEFAULT NULL ,
  `outros_organizacao_ciclos` smallint(3) DEFAULT NULL ,
  `matriculas_creche` smallint(4) unsigned DEFAULT NULL ,
  `matriculas_pre_escolar` smallint(4) unsigned DEFAULT NULL ,
  `matriculas_anos_iniciais` smallint(4) unsigned DEFAULT NULL ,
  `matriculas_anos_finais` smallint(4) unsigned DEFAULT NULL ,
  `matriculas_ensino_medio` smallint(4) unsigned DEFAULT NULL ,
  `matriculas_eja` smallint(4) unsigned DEFAULT NULL ,
  `matriculas_educacao_especial` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_1ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_2ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_3ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_4ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_5ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_6ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_7ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_8ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_9ano` smallint(3) unsigned DEFAULT NULL ,
  `matriculas_em_1ano` smallint(11) unsigned DEFAULT NULL,
  `matriculas_em_2ano` smallint(11) unsigned DEFAULT NULL,
  `matriculas_em_3ano` smallint(11) unsigned DEFAULT NULL,
  `matriculas_em_outros` smallint(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `busca` (`educacenso`,`state_id`,`school_id`,`city_id`),
  KEY `escola` (`school_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SQL
            )->execute();
    }

    public function populateWithSchoolRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `school_educacenso`
VALUES (
	2190587,
	113,
	1597,
	142950,
	2017,
	0, 
	1,
    NULL, 
    NULL, 
    0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 
    10, 1, 1, 1, 1, 1, 1, 1, 30, 1, 0, 28, 103, 100, 0, 0, 7, 15, 24, 24, 24, 16, 18, 22, 26, 34, 0, 0, 0, 0
), (
    1793018, 
    113, 
    1597, 
    142950, 
    2016, 
    0, 
    1, 
    NULL, 
    NULL, 
    0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0, 
    10, 1, 1, 1, 1, 1, 1, 1, 33, 0, 0, 27, 103, 110, 0, 0, 0, 21, 22, 23, 16, 21, 22, 28, 36, 24, 0, 0, 0, 0
);

SQL
            )->execute();
    }
}
