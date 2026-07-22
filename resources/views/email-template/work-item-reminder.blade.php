<h2>Work Item Reminder</h2>

<p>Hello {{ $reminder->name }},</p>

<p>Your assigned work item is nearing its deadline.</p>

<table border="1" cellpadding="10">

<tr>

    <td><strong>Project</strong></td>

    <td>{{ $reminder->project_title }}</td>

</tr>

<tr>

    <td><strong>Work Item</strong></td>

    <td>{{ $reminder->title }}</td>

</tr>

<tr>

    <td><strong>Description</strong></td>

    <td>{!! $reminder->description !!}</td>

</tr>

<tr>

    <td><strong>Due Date</strong></td>

    <td>{{ $reminder->end_date }}</td>

</tr>

</table>

<br>

Thanks,