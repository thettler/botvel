<?php

use Thettler\Botvel\Facades\Botvel;

it('can call driver migrators', function () {
    Botvel::fake();
    Botvel::command('test', fn() => '');

    /** @var \Thettler\Botvel\BotvelMigrator $migrator */
    $migrator = app(\Thettler\Botvel\BotvelMigrator::class);
    $migrator->migrate();

    expect($migrator->isCommandMigrated('test', \Thettler\Botvel\Fakes\FakeDriver::key()))
        ->toBeTrue();
});


it('asdas', function () {
    dd(combinations(['A', 'B', 'C', 'D'], 2));
});

function subcombi(array $arr, int $arr_size, int $count): array
{
    $combi_arr = [];

    if ($count <= 1) {
        for ($i = $count - 1; $i < $arr_size; $i = $i + 1) {
            $combi_arr[] = [$arr[$i]];
        }

        return $combi_arr;
    }


    for ($i = $count - 1; $i < $arr_size; $i = $i + 1) {
        $highest_index_elem_arr = [$i => $arr[$i]];
        foreach (subcombi($arr, $i, $count - 1) as $subcombi_arr) {
            $combi_arr[] = [...$subcombi_arr, ...$highest_index_elem_arr];
        }
    }

    return $combi_arr;
}

function combinations(array $items, int $count): array
{
    $itemCount = count($items);

    if ($count <= 0
        || $count > $itemCount) {
        return [];
    }

    return subcombi($items, $itemCount, $count);
}
