<?php
class Query
{
  public $query = '
query {
            search(type: REPOSITORY, first: 100, query: """
                stars:>100
                language:{language}
            """) {
                nodes {
                ... on Repository {
                    url
                    name
                    primaryLanguage {
                      name
                    }
                    nameWithOwner
                    stargazerCount
                    watchers {
                      totalCount
                    }
                    createdAt
                }
                }
            }
        }
      ';

  function mountQuery($language)
  {

    $readyQuery = str_replace(array('{language}'), array($language), $this->query);
    return $readyQuery;
  }
}
