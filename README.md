QEdu Hub
========

[![Build Status](https://travis-ci.org/QEdu/qedu-hub.svg?branch=master)](https://travis-ci.org/QEdu/qedu-hub)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/QEdu/qedu-hub/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/QEdu/qedu-hub/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/QEdu/qedu-hub/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/QEdu/qedu-hub/?branch=master)
[![StyleCI](https://styleci.io/repos/92977560/shield?branch=master)](https://styleci.io/repos/92977560)

QEdu Hub is the new version of qedu.org.br, our mission is to improve Brazilian education by using technology and data.

QEdu Hub é a nova versão do qedu.org.br, nossa missão é melhorar a educação Brasileira através de tecnologia e dados.

# Install

1. Clone this repository
2. Enter inside the new project directory, like: /home/qedu-hub
3. Run `docker-compose up`
4. Install dependencies `docker run -it -v /home/ubuntu/qedu-hub:/app composer /bin/bash`, replace the {/home/ubuntu/qedu-hub} to repository full path.
5. Inside the composer container run `composer install`
6. Composer ask for some variables, fill with the database configurations and other connections. For redis, put `qeduhub_redis`
