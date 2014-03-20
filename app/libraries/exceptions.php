<?php

// Thrown when a model does not pass validation
class ModelValidationException extends \Exception {}

// Thrown when triying to delete a model that should not be delete
class ModelDeletionException extends \Exception {}
