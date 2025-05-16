<?php

namespace app\controllers\api\v1;

use app\models\Category;
use app\models\Coupon;
use app\models\CouponClaim;
use app\models\Customer;
use app\models\Employee;
use app\models\EmployeeUser;
use app\models\Market;
use app\models\Product;
use app\models\SupplyData;
use app\models\User;
use PhpParser\Node\Expr\Throw_;
use yii\data\ActiveDataProvider;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;

class EntityController extends RestController
{
    public function actionCreate($controller)
    {
        $model = $this->createEntity($controller);
        $model->load($this->request->post(), '');
        if (!$model->validate()) {
            return $this->prepareMessage(400, [
                'messages' => $model->errors,
            ]);
        }
        $model->save(false);
        return $this->prepareMessage(201, [
            'id' => $model->getId(),
        ]);
    }

    public function actionUpdate($controller, $id)
    {
        $model = $this->updateEntity($controller, $id);
        if (!$model) {
            return $this->prepareMessage(404, [
                'message' => Inflector::singularize(Inflector::camel2words($controller)) . ' not found'
            ]);
        }
        $model->load($this->request->post(), '');
        if (!$model->validate()) {
            return $this->prepareMessage(400, [
                'messages' => $model->errors,
            ]);
        }
        $model->save(false);
        return $this->prepareMessage(201, [
            'id' => $model->getId(),
        ]);
    }

    public function actionList($controller, $pageSize = 10, $page = 0)
    {
        $model = $this->getEntity($controller);
        $query = $this->getEntityQuery($controller);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page
            ],
        ]);
        return $this->prepareMessage(200, [
            'page' => $dataProvider->pagination->page,
            'pageSize' => $dataProvider->pagination->pageSize,
            'result' => $dataProvider->getModels()
        ]);
    }

    public function actionDelete($controller, $id)
    {
        $model = $this->deleteEntity($controller, $id);
        if (!$model) {
            return $this->prepareMessage(404, [
                'message' => Inflector::singularize(Inflector::camel2words($controller)) . ' not found'
            ]);
        }
        $model->isDeleted = 0;
        $model->save(false);
        return $this->prepareMessage(204,[]);
    }

    function getEntity($entityName)
    {
        return match ($entityName) {
            'categories' => Category::find(),
            'products' => Product::find(),
            'markets' => Market::find(),
            'employees' => Employee::find(),
            'supplies' => SupplyData::find(),
            'customers' => Customer::find(),
            'coupons' => Coupon::find(),
            default => User::find(),
        };
    }

    function getEntityQuery($entityName)
    {
        return match ($entityName) {
            'categories' => Category::find(),
            'products' => Product::find(),
            'markets' => Market::find(),
            'employees' => Employee::find(),
            'supplies' => SupplyData::find(),
            'customers' => Customer::find(),
            'coupons' => Coupon::find(),
            default => User::find(),
        };
    }

    function updateEntity($entityName, $id)
    {
        return match ($entityName) {
            'categories' => Category::findOne($id),
            'products' => Product::findOne($id),
            'markets' => Market::findOne($id),
            'employees' => Employee::findOne($id),
            'supplies' => SupplyData::findOne($id),
            'customers' => Customer::findOne($id),
            'coupons' => Coupon::findOne($id),
            default => null,
        };
    }

    function deleteEntity($entityName, $id)
    {
        return match ($entityName) {
            'categories' => Category::findOne($id),
            'products' => Product::findOne($id),
            'markets' => Market::findOne($id),
            default => null,
        };
    }


    function createEntity($entityName)
    {
        return match ($entityName) {
            'categories' => new Category(),
            'products' => new Product(),
            'markets' => new Market(),
            'employees' => new EmployeeUser(),
            'supplies' => new SupplyData(),
            'customers' => new Customer(),
            'coupons' => new Coupon(),
            default => new User(),
        };
    }

    function addFunction($entityName)
    {
        return match ($entityName) {
            'employees' => $this->addUserForEmployee(),
            default => new User(),
        };
    }

    private function addUserForEmployee()
    {
        return true;
    }
}