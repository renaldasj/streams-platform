<?php namespace Anomaly\Streams\Platform\Version\Table;

use Illuminate\Contracts\Config\Repository;

/**
 * Class VersionTableColumns
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class VersionTableColumns
{

    /**
     * Handle the columns.
     *
     * @param VersionTableBuilder $builder
     * @param Repository          $config
     */
    public function handle(VersionTableBuilder $builder, Repository $config)
    {
        $date = $config->get('streams::datetime.date_format');
        $time = $config->get('streams::datetime.time_format');

        $builder->setColumns(
            [
                'author'     => [
                    'heading'    => 'streams::label.author',
                    'wrapper'    => '
                        <strong>{value.name}</strong>
                        <br>
                        {value.email}
                        <br>
                        <small class="text-muted">{value.ip_address}</small>
                        ',
                    'value'      => [
                        'ip_address' => 'entry.ip_address',
                        'email'      => 'entry.created_by.email',
                        'name'       => 'entry.created_by.display_name',
                    ],
                    //'sort_column' => 'name',
                    'attributes' => [
                        'style' => 'width: 250px;',
                    ],
                ],
                'created_at' => [
                    'heading'     => 'streams::label.date',
                    'sort_column' => 'created_at',
                    'wrapper'     => '
                        {value.datetime}
                        <br>
                        <small class="text-muted">{value.timeago}</small>',
                    'value'       => [
                        'datetime' => "entry.created_at.format('{$date} {$time}')",
                        'timeago'  => 'entry.created_at.diffForHumans()',
                    ],
                ],
//                'changes'    => [
//                    'heading' => 'streams::label.changes',
//                    'wrapper' => '
//                        {{ entry.data|length }} {{ trans_choice("streams::version.changes", entry.data|length) }}
//                        <br>
//                        <small class="text-muted">{{ ucwords(entry.data|keys|join(", ")) }}</small>',
//                ],
            ]
        );
    }
}