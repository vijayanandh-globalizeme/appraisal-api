<style type="">
	.container{
	    padding: 1rem 2rem;
	    font-family: sans-serif;
	}
	.header{
		text-align: center;
		margin: 8px 12px;
	}

	.user-card{
		background: #d7d7d7;
	    padding: 0.5rem 1rem;
	    border-radius: 10px;
	}
	table.report-table{
		width: 100%;
	    border-spacing: 1;
	    border-collapse: collapse;
	    background: #fff;
	    border-radius: 10px;
	    overflow: hidden;
	    width: 100%;
	    margin: 0 auto;
	    position: relative;
	    margin-top: 1rem;
	}
	table.title{
		width: 100%;
	    border-collapse: collapse;
	}
	table.title td{
	    padding: 12px 1.5rem;
	    color: #fff;
		background: #8a82a6;
	}	
	table.title td:first-child, table.table-content td:first-child{
		width: 60%;
	}
	table.table-title{
    	font-size: 18px;
    	padding: 1rem 1.5rem;
    	color: #fff;
	    width: 100%;
	    text-align: center;
		background: #36304a;
	}
	.padd0{
		padding: 0;
	}
	table.table-content{
	    border-collapse: collapse;
	    width: 100%;
	}
	table.table-content tbody tr:nth-child(even){
		background: #ededed;
	}
	table.table-content tbody tr:nth-child(odd){
		background: #f5f5f5;
	}
	table.table-content tbody td{
    	padding: 12px 1.5rem;
    	color: #808080;
	}
	.text-green{
		color: #3cb27f !important;
	}
	.page-break {
	    page-break-after: always;
	}
</style>

<div class="container">
	<div class="header">
		<img src="data:image/png;base64,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">
	</div>

	<div class="user-card">
		<p><b>Colleague Name:</b> {{ $reviews["data"]["user"]["name"] }}</p>
		<p><b>Email Address:</b> {{ $reviews["data"]["user"]["email"] }}</p>
		<p><b>Report Submission:</b> {{ date("d M, Y", strtotime($reviews["data"]['created_at'])) }}</p>
	</div>

	<table class="report-table">
		<tbody>
			<tr>
				<td class="padd0">
					<?php foreach ($reviews["category"] as $category) { ?>

						<table class="table-title">
			                <tr>
			                    <td>{{ $category['name'] }}</td>
			                </tr>
			            </table>
						<table class="title">
			                <tr>
			                    <td>Review Question</td>
			                    <td>Team Member input</td>
			                </tr>
			            </table>
			            <?php $answer = $reviews['data']['answer']; ?>
			            <?php if($reviews['data']){ ?>
				            <table class="table-content">
					            <?php foreach ($reviews["questions"] as $key => $question) { ?>
					            	<?php 
					            		if(
					            			$question["category_id"] == $category["id"] 
					            			&& isset($answer[$question["name"]])
					            			&& $answer[$question["name"]] != null
					            		){ 
					            	?>
						            	<tr>
						                    <td>{{ $question["label"] }}</td>
											<td class="text-green">
												{{ $answer[$question["name"]] }}
											</td>
						                </tr>
					            	<?php } ?>

					            <?php } ?>
					        </table>
					        <div class="page-break"></div>
					    <?php } ?>
		        	<?php } ?>
		        </td>
			</tr>
		</tbody>
	</table>

</div>
