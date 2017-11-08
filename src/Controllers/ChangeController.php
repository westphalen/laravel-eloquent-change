<?php
/**
 * Created by PhpStorm.
 * User: sune
 * Date: 08/02/2017
 * Time: 23.32
 */
namespace Westphalen\Laravel\Change\Controllers;

use Illuminate\Routing\Controller;
use Westphalen\Laravel\Change\Models\Change;

class ChangeController extends Controller
{
    /**
     * Apply the specified resource.
     *
     * @param   string  $id
     * @return  \Dingo\Api\Http\Response
     */
    public function apply($id)
    {
        $change = Change::findOrFail($id);

        if ($change->isExpired()) {
            return response()->make('Change has expired.', 404);
        }

        if ($change->isApplied()) {
            return response()->make('Change has already been applied.', 404);
        }

        $change->apply();

        return response()->make('Change was successfully applied.', 202);
    }

}
