To use, you must first create a Laravel project
Then enter the app folder through the command cd app
Then run the command  git clone https://github.com/lithiumx57/Panel.git  to download the information
And finally in the file web.php run the function AdminDynamicModels::initialize();

  protected function fields(): array
  {
    return [
      xStringField("name", xLabel("نام دسته بندی"), xShowInAdmin()),
      xBoolField("approved", xLabel("فعال"), xDefault(true)),
      xForeignField("parent", Category::class, "parentCategory", ['name'], null,
        xLabel("دسته پدر"),
        xConditions(['parent' => 0]),
        xDefaultSelectItems([0 => "دسته اصلی"])
      )
    ];
  }

