$(document).ready(function(){
    $('#client-select').select2();


    /*Menu-toggle*/
    $("#menu-toggle").on('click', function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });

    var clientId = null;
    var jobId = null;
    var phaseId = null;
    
    /** Reporting-Specific Code */
    $('#client-select').on('change', function() {
        jobId = null;
        phaseId = null;
        clientId = $(this).val();
        alert(clientId);
        $('input[name="client_id"]').val(clientId);
        $('#phase-select, #job-select').html('');

        $.ajax({
            url: '/report/get_jobs_for_client',
            data: 'client_id=' + clientId,
            type: 'get',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('#job-select').html('');
                if(data.length > 0) {
                    for(var i in data){
                        $('#job-select').append('<option value="'+ data[i].id +'">'+data[i].name+'</option>');
                    }
                    
                    $('#job-select > option').on('click', function(){
                        $('#phase-select').html('');
                        phaseId = null;
                        jobId = $(this).val();
                        $('input#job_id').val(jobId);
                
                        $.ajax({
                            url: '/report/get_phases_for_job',
                            data: 'job_id=' + jobId,
                            type: 'get',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(phases) {
                                if(!phases.hasOwnProperty('error')) {
                                    $('#phase-select').html('');
                                    for(var i in phases){
                                        $('#phase-select').append('<option value="'+ phases[i].id +'">'+phases[i].name+'</option>');
                                    }
                                    $('#phase-select > option').on('click',function(){
                                        phaseId = $(this).val();
                                    });
                                } else {
                                    // Replace with a real flash message
                                    console.log(phases);
                                    // console.log('Phase already exists');
                                }
                            }
                        });
                    });
                }
            }
        });
    });

    

    $('input#init-report').on('click', function(e){
        console.log(phaseId, clientId, jobId);
        if(phaseId === null || clientId === null || jobId === null) {
            alert('Please select a Client, Job and Phase');
            e.preventDefault();
            return false;
        } else {
            $('form[name="init_report"]').append('<input type="hidden" name="client_id" value="'+ clientId +'">');
            $('form[name="init_report"]').append('<input type="hidden" name="job_id" value="'+ jobId +'">');
            $('form[name="init_report"]').append('<input type="hidden" name="phase_id" value="'+ phaseId +'">');
        }
    });

    $('input#s-add-job-to-client').on('click', function(e) {
        e.preventDefault();
    
        $.ajax({
            url: '/report/add_job_to_client',
            data: $('form#add-job-to-client').serialize(),
            type: 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(jobs) {
                if(!jobs.hasOwnProperty('error')) {
                    $('#job-select').html('');
                    for(var i in jobs){
                        $('#job-select').append('<option value="'+ jobs[i].id +'">'+jobs[i].name+'</option>');
                    }
                } else {
                    // Replace with a real flash message
                    alert(jobs.error);
                    console.log('Job already exists');
                }
            }
        });
    });

    $('input#s-add-phase-to-job').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/report/add_phase_to_job',
            data: $('form#add-phase-to-job').serialize(),
            type: 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(phases) {
                if(!phases.hasOwnProperty('error')) {
                    $('#phase-select').html('');
                    for(var i in phases){
                        $('#phase-select').append('<option value="'+ phases[i].id +'">'+phases[i].name+'</option>');
                    }
                } else {
                    // Replace with a real flash message
                    alert(phases.error);
                    console.log('Phase already exists');
                }
            }
        });
    });


    /** 
     * Multi-Select 
     */
    if($('select#vulnerability-select').length){
        $('select#vulnerability-select').select2();
    }    

    $('#add-to-report').on('click', function(ev) {
        var ids = [];
        $('#vulnerability-select > option:selected').each(function(index, el) {
            ids.push($(el).val());
        });
        
        var reportId = parseInt($('meta[name="report_id"]').attr('value'));
        var reportData = {report_id: reportId, vuln_ids: ids};
        var success = false;
        
        $.ajax({
            url: '/report/add-to-report',
            method: 'post',
            data: reportData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
                if(data.hasOwnProperty('vulns')) {
                    for(var i in data.vulns) {
                        $('select#report-vulnerabilities').append('<option name="'+data.vulns[i].id+'">'+data.vulns[i].title+'</option>')
                    }
                }
            }
        });
    });
    
    if($('table').length) {
        $('table').dataTable();
    }
});
