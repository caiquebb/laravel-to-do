<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\Request;

class TodoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoItem  $todoItem
     * @return \Illuminate\Http\Response
     */
    public function show(TodoItem $todoItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoItem  $todoItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoItem $todoItem)
    {
        $todoItem->fill($request->all());

        $dirty = $todoItem->getDirty();

        $todoItem->save();

        // If change field completed then check parent ans childs.
        if (array_key_exists('completed', $dirty)) {
            if ($todoItem->todo_item_id) {
                // if children check if all the children have the same value to update de parent
                $count = TodoItem::where([
                    ['todo_item_id', $todoItem->todo_item_id],
                    ['completed', '!=', $todoItem->completed],
                    ['id', '!=', $todoItem->id],
                ])->count();

                $parentCompleted = $count === 0 ? $todoItem->completed : false;

                TodoItem::where('id', $todoItem->todo_item_id)->update(['completed' => $parentCompleted]);
            } else {
                // If parent then change all children to the same value from parent
                TodoItem::where('todo_item_id', $todoItem->id)->update(['completed' => $todoItem->completed]);
            }
        }

        return $todoItem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoItem  $todoItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoItem $todoItem)
    {
        return $todoItem->delete();
    }
}
