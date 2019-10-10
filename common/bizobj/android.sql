--
-- Name: instances; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--

CREATE TABLE instances (
    inst_seq integer NOT NULL,
    inst_id character varying(14) NOT NULL,
    worker_seq integer NOT NULL,
    inst_created timestamp without time zone DEFAULT now(),
    inst_adm_port integer,
    inst_active boolean DEFAULT false,
    inst_type character varying(1),
    inst_license character varying(35),
    inst_nusers integer DEFAULT 5,
    inst_lang character varying(5),
    inst_name character varying(200) NOT NULL,
    inst_version character varying(200),
    inst_num_of_passwd_to_store integer,
    inst_max_pwd_age integer,
    inst_pol_port integer,
    inst_cnpj character varying(200),
    inst_phone character varying(200)
);
--
-- Name: instances_inst_seq_seq; Type: SEQUENCE; Schema: public; Owner: wtm
--
CREATE SEQUENCE instances_inst_seq_seq
    START WITH 4000
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--
-- Name: instances_inst_seq_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wtm
--
ALTER SEQUENCE instances_inst_seq_seq OWNED BY instances.inst_seq;

--
-- Name: users; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--
CREATE TABLE users (
    usu_seq integer NOT NULL,
    usu_email character varying(256) NOT NULL,
    usu_name character varying(256) NOT NULL,
    usu_passwd_digest character varying(100) NOT NULL,
    usu_language character varying(20),
    usu_twofact_type character varying(100),
    usu_twofact_token character varying(100),
    usu_updated_passwd_at timestamp without time zone,
    usu_num_of_passwd_to_store integer,
    usu_max_pwd_age integer,
    usu_pwd_history text,
    usu_caps text
);
--
-- Name: users_instances; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--
CREATE TABLE users_instances (
    usuinst_seq integer NOT NULL,
    usu_seq integer NOT NULL,
    inst_seq integer NOT NULL,
    usuinst_privs character varying(20),
    usuinst_privs_groups character varying(100)
);
--
-- Name: users_instances_usuinst_seq_seq; Type: SEQUENCE; Schema: public; Owner: wtm
--

CREATE SEQUENCE users_instances_usuinst_seq_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--
-- Name: users_instances_usuinst_seq_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wtm
--

ALTER SEQUENCE users_instances_usuinst_seq_seq OWNED BY users_instances.usuinst_seq;


--
-- Name: users_usu_seq_seq; Type: SEQUENCE; Schema: public; Owner: wtm
--

CREATE SEQUENCE users_usu_seq_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_usu_seq_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wtm
--

ALTER SEQUENCE users_usu_seq_seq OWNED BY users.usu_seq;


--
-- Name: virt_device; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--

CREATE TABLE virt_device (
    vd_seq integer NOT NULL,
    vds_seq integer,
    inst_seq integer NOT NULL,
    vd_s_index integer,
    vd_owner character varying(200) NOT NULL,
    vd_number character varying(100),
    vd_key character varying(100) NOT NULL,
    vd_status integer NOT NULL
);


--
-- Name: virt_device_server; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--

CREATE TABLE virt_device_server (
    vds_seq integer NOT NULL,
    vds_name character varying(200) NOT NULL,
    inst_seq integer,
    vds_active boolean,
    vds_maxdevs integer NOT NULL
);


--
-- Name: virt_device_server_vds_seq_seq; Type: SEQUENCE; Schema: public; Owner: wtm
--

CREATE SEQUENCE virt_device_server_vds_seq_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: virt_device_server_vds_seq_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wtm
--

ALTER SEQUENCE virt_device_server_vds_seq_seq OWNED BY virt_device_server.vds_seq;


--
-- Name: virt_device_vd_seq_seq; Type: SEQUENCE; Schema: public; Owner: wtm
--

CREATE SEQUENCE virt_device_vd_seq_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: virt_device_vd_seq_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wtm
--

ALTER SEQUENCE virt_device_vd_seq_seq OWNED BY virt_device.vd_seq;


--
-- Name: workers; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--

CREATE TABLE workers (
    worker_seq integer NOT NULL,
    worker_hostname character varying(256) NOT NULL,
    worker_frontend character varying(256) NOT NULL,
    worker_created timestamp without time zone DEFAULT now(),
    worker_ip character varying(16),
    worker_active boolean DEFAULT false,
    worker_last_boot timestamp without time zone
);

--
-- Name: workers_worker_seq_seq; Type: SEQUENCE; Schema: public; Owner: wtm
--

CREATE SEQUENCE workers_worker_seq_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: workers_worker_seq_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wtm
--

ALTER SEQUENCE workers_worker_seq_seq OWNED BY workers.worker_seq;


--
-- Name: inst_seq; Type: DEFAULT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY instances ALTER COLUMN inst_seq SET DEFAULT nextval('instances_inst_seq_seq'::regclass);


--
-- Name: usu_seq; Type: DEFAULT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY users ALTER COLUMN usu_seq SET DEFAULT nextval('users_usu_seq_seq'::regclass);


--
-- Name: usuinst_seq; Type: DEFAULT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY users_instances ALTER COLUMN usuinst_seq SET DEFAULT nextval('users_instances_usuinst_seq_seq'::regclass);


--
-- Name: vd_seq; Type: DEFAULT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY virt_device ALTER COLUMN vd_seq SET DEFAULT nextval('virt_device_vd_seq_seq'::regclass);


--
-- Name: vds_seq; Type: DEFAULT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY virt_device_server ALTER COLUMN vds_seq SET DEFAULT nextval('virt_device_server_vds_seq_seq'::regclass);


--
-- Name: worker_seq; Type: DEFAULT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY workers ALTER COLUMN worker_seq SET DEFAULT nextval('workers_worker_seq_seq'::regclass);


--
-- Data for Name: instances; Type: TABLE DATA; Schema: public; Owner: wtm
--

COPY instances (inst_seq, inst_id, worker_seq, inst_created, inst_adm_port, inst_active, inst_type, inst_license, inst_nusers, inst_lang, inst_name, inst_version, inst_num_of_passwd_to_store, inst_max_pwd_age, inst_pol_port, inst_cnpj, inst_phone) FROM stdin;
1	E8D2D8286FAE7E	1	2019-09-18 17:21:23.510212	10001	f	X	\N	5	br	Inst 1	\N	\N	\N	\N	\N	\N
\.


--
-- Name: instances_inst_seq_seq; Type: SEQUENCE SET; Schema: public; Owner: wtm
--

SELECT pg_catalog.setval('instances_inst_seq_seq', 1, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: wtm
--

COPY users (usu_seq, usu_email, usu_name, usu_passwd_digest, usu_language, usu_twofact_type, usu_twofact_token, usu_updated_passwd_at, usu_num_of_passwd_to_store, usu_max_pwd_age, usu_pwd_history, usu_caps) FROM stdin;
1	nigri@winco.com.br	Ariel Nigri	52cb26e8f0b9579c219882b84ec99a67	\N	\N	\N	2019-09-23 18:39:09	\N	\N	\N	ADMIN
\.


--
-- Data for Name: users_instances; Type: TABLE DATA; Schema: public; Owner: wtm
--

COPY users_instances (usuinst_seq, usu_seq, inst_seq, usuinst_privs, usuinst_privs_groups) FROM stdin;
\.


--
-- Name: users_instances_usuinst_seq_seq; Type: SEQUENCE SET; Schema: public; Owner: wtm
--

SELECT pg_catalog.setval('users_instances_usuinst_seq_seq', 1, false);


--
-- Name: users_usu_seq_seq; Type: SEQUENCE SET; Schema: public; Owner: wtm
--

SELECT pg_catalog.setval('users_usu_seq_seq', 4, true);

--
-- Data for Name: virt_device_server; Type: TABLE DATA; Schema: public; Owner: wtm
--

COPY virt_device_server (vds_seq, vds_name, inst_seq, vds_active, vds_maxdevs) FROM stdin;
1	whatsapp-01.talkmanager.net	\N	t	3
\.


--
-- Name: virt_device_server_vds_seq_seq; Type: SEQUENCE SET; Schema: public; Owner: wtm
--

SELECT pg_catalog.setval('virt_device_server_vds_seq_seq', 1, true);


--
-- Name: virt_device_vd_seq_seq; Type: SEQUENCE SET; Schema: public; Owner: wtm
--

SELECT pg_catalog.setval('virt_device_vd_seq_seq', 10, true);


--
-- Data for Name: workers; Type: TABLE DATA; Schema: public; Owner: wtm
--

COPY workers (worker_seq, worker_hostname, worker_frontend, worker_created, worker_ip, worker_active, worker_last_boot) FROM stdin;
1	centos7-64.localdomain	centos7-64.localdomain	2019-09-18 16:19:39.924304	127.0.0.1	t	\N
\.


--
-- Name: workers_worker_seq_seq; Type: SEQUENCE SET; Schema: public; Owner: wtm
--

SELECT pg_catalog.setval('workers_worker_seq_seq', 1, true);


--
-- Name: instances_inst_id_key; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY instances
    ADD CONSTRAINT instances_inst_id_key UNIQUE (inst_id);


--
-- Name: instances_pkey; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY instances
    ADD CONSTRAINT instances_pkey PRIMARY KEY (inst_seq);


--
-- Name: users_instances_pkey; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY users_instances
    ADD CONSTRAINT users_instances_pkey PRIMARY KEY (usuinst_seq);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (usu_seq);


--
-- Name: users_usu_email_key; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_usu_email_key UNIQUE (usu_email);


--
-- Name: virt_device_pkey; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY virt_device
    ADD CONSTRAINT virt_device_pkey PRIMARY KEY (vd_seq);


--
-- Name: virt_device_server_pkey; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY virt_device_server
    ADD CONSTRAINT virt_device_server_pkey PRIMARY KEY (vds_seq);


--
-- Name: workers_pkey; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY workers
    ADD CONSTRAINT workers_pkey PRIMARY KEY (worker_seq);


--
-- Name: workers_worker_hostname_key; Type: CONSTRAINT; Schema: public; Owner: wtm; Tablespace: 
--

ALTER TABLE ONLY workers
    ADD CONSTRAINT workers_worker_hostname_key UNIQUE (worker_hostname);


--
-- Name: virt_device_vd_number; Type: INDEX; Schema: public; Owner: wtm; Tablespace: 
--

CREATE UNIQUE INDEX virt_device_vd_number ON virt_device USING btree (vd_number);


--
-- Name: instances_worker_seq_fkey; Type: FK CONSTRAINT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY instances
    ADD CONSTRAINT instances_worker_seq_fkey FOREIGN KEY (worker_seq) REFERENCES workers(worker_seq);


--
-- Name: users_instances_inst_seq_fkey; Type: FK CONSTRAINT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY users_instances
    ADD CONSTRAINT users_instances_inst_seq_fkey FOREIGN KEY (inst_seq) REFERENCES instances(inst_seq);


--
-- Name: users_instances_usu_seq_fkey; Type: FK CONSTRAINT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY users_instances
    ADD CONSTRAINT users_instances_usu_seq_fkey FOREIGN KEY (usu_seq) REFERENCES users(usu_seq);


--
-- Name: virt_device_inst_seq_fkey; Type: FK CONSTRAINT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY virt_device
    ADD CONSTRAINT virt_device_inst_seq_fkey FOREIGN KEY (inst_seq) REFERENCES instances(inst_seq);


--
-- Name: virt_device_server_inst_seq_fkey; Type: FK CONSTRAINT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY virt_device_server
    ADD CONSTRAINT virt_device_server_inst_seq_fkey FOREIGN KEY (inst_seq) REFERENCES instances(inst_seq);


--
-- Name: virt_device_vds_seq_fkey; Type: FK CONSTRAINT; Schema: public; Owner: wtm
--

ALTER TABLE ONLY virt_device
    ADD CONSTRAINT virt_device_vds_seq_fkey FOREIGN KEY (vds_seq) REFERENCES virt_device_server(vds_seq);
