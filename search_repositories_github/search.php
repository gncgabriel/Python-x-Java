<?php
require_once __DIR__ . '/query.php';
require_once __DIR__ . '/conection.php';
require_once __DIR__ . '/csv.php';

function searchRepositories($token = '', $dir = null)
{


  $query = new Query();
  $nodes = array();


  $nodes[] = executaQuery(array('query' => $query->mountQuery('Python')), $token);
  $nodes[] = executaQuery(array('query' => $query->mountQuery('Java')), $token);


  $cabecalho = array(
    "Nome Usuario/Repositorio",
    "Linguagem",
    "Linhas em branco",
    "Linhas de Comentário",
    "Linhas de Código",
    "Estrelas",
    "Watchers",
    "Data Criação",
  );

  apagarCsv($dir);
  createCsv($cabecalho, $dir);

  $a = 0;
  foreach ($nodes as $langs) {
    $results = $langs['data']['search']['nodes'];
    foreach ($results as $key) {
      $repo = $key['url'];
      //shell_exec("git --bare clone $repo $dir/REPO");
      shell_exec("wget $repo/archive/master.zip -P $dir/REPO");

      $analise = json_decode(shell_exec("cloc $dir/REPO/master.zip --json --git --quiet "), true);

      $dados = array(
        $key['nameWithOwner'],
        $key['primaryLanguage']['name'],
        $analise['SUM']['blank'],
        $analise['SUM']['comment'],
        $analise['SUM']['code'],
        $key['stargazerCount'],
        $key['watchers']['totalCount'],
        $key['createdAt']

      );

      createCsv($dados, $dir);
      shell_exec("rm -rf $dir/REPO");
      $a++;
      echo "\n$a Repositórios Analizados\n\n";
    }
  }

}
