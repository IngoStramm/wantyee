<?php
$lead_id = get_the_ID();
$lead_author_id = $post->post_author;
$lead_author_data = get_userdata($lead_author_id);
$anuncio_id = get_post_meta($lead_id, 'wt_anuncio_id', true);
$anuncio = get_post($anuncio_id);
$anuncio_author_id = $anuncio->post_author;
$anuncio_author_data = get_userdata($anuncio_author_id);
$anuncio_status = get_post_meta($anuncio_id, 'wt_anuncio_status', true);
?>

<td class="titulo">
    <a href="<?php echo get_post_permalink($anuncio_id); ?>">
        <?php echo get_the_title($anuncio_id); ?>
    </a>
</td>
<td class="comprador">
    <?php echo $anuncio_author_data->first_name && $anuncio_author_data->last_name ?
        $anuncio_author_data->first_name . ' ' . $anuncio_author_data->last_name :
        $anuncio_author_data->display_name ?>
</td>
<td class="vendedor">
    <?php echo $lead_author_data->first_name && $lead_author_data->last_name ?
        $lead_author_data->first_name . ' ' . $lead_author_data->last_name :
        $lead_author_data->display_name ?>
</td>
<td class="data">
    <?php echo get_the_date('', $lead_id); ?>
</td>
<td class="status">
    <?php echo $anuncio_status === 'closed' ? __('Encerrado', 'wt') : __('Aberto', 'wt'); ?>
</td>