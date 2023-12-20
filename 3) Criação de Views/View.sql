
create view dim_Institution as select id as "id_institution",name from institution;
create view dim_Scheduler as select id as "id_scheduler",name from scheduler;
create view dim_Cluster as select id as "id_cluster",name, num_cores from clusters;
create view dim_Queue as select id as "id_queue", name, num_cores as "num_cores_fila" from queues;
create view dim_Platform as select id as "id_platform", name from platforms;
create view dim_Algorithm_Type as select id as "id_algorithm_type", algorithm_type from algorithm_types;

create view dim_Application as SELECT f.id as "id_application", f.name as "name_aplication", o.version_name, 
x.num_cores as "num_cores_requested" FROM applications f 
JOIN versions o ON o.id=f.id 
JOIN apps_versions_platforms x ON x.id=o.id;

create view dim_Gateway as select id as "id_gateway",name from gateway;
create view dim_Country as select id as "id_country", name from countries;
create view dim_User_Bioinfo as select id as "id_user",email from users_bioinfo;
create view dim_Job_File as select id as "id_file", path, size, input_file from files;
create view dim_status as select id as "id_status", status from executions;
create view dim_Tempo as select id as "id_tempo", date(start_time) from executions;
create view dim_Job as select id as "id_job", date(start_time), id_web, id_csgrid   from executions;


create view fato_Execution as 
SELECT w.id_user, d.id_file, x.id_application, f.id_tempo, v.id_cluster, h.id_gateway, p.id_platform, 
q.id_queue, m.id_scheduler, s.id_algorithm_type, l.id_country, r.id_institution,i.id_status, j.id_job, o.cpu_time, 
cast (o.start_time as timestamp(0)) :: timestamp :: time as "start_time", cast (o.end_time as timestamp(0)) :: timestamp :: time as "end_time", o.parameters
FROM dim_user_bioinfo w, executions o, dim_job_file d, dim_application x, dim_tempo f, dim_cluster v, dim_gateway h,
dim_platform p, dim_queue q, dim_scheduler m, dim_algorithm_type s, dim_country l, dim_institution r, dim_status i, dim_job j
where w.id_user = o.id and 
o.id = d.id_file and
d.id_file = x.id_application and
x.id_application = f.id_tempo and
f.id_tempo = v.id_cluster and
v.id_cluster = h.id_gateway and
h.id_gateway = p.id_platform and
p.id_platform = q.id_queue and
q.id_queue = m.id_scheduler and
m.id_scheduler = s.id_algorithm_type and
s.id_algorithm_type = l.id_country and
l.id_country = r.id_institution and
r.id_institution = i.id_status and 
i.id_status=j.id_job
;