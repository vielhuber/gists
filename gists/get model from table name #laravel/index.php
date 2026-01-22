function getModelFromTable($table)
{
  foreach ($this->getAllModels() as $models__value) {
    $models__value = 'App\\' . $models__value;
    $model_instance = new $models__value;
    if ($model_instance->getTable() === $table) {
      return $model_instance;
    }
  }
  return null;
}

function getAllModels()
{
  $models = [];
  $results = scandir(app_path() . '/Models'); // choose path of model
  foreach ($results as $results__value) {
    if ($results__value === '.' or $results__value === '..') {
      continue;
    }
    $models[] = substr($results__value, 0, -4);
  }
  return $models;
}