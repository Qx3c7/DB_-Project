PGDMP  $    :                |           runners_app    16.3    16.3     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16398    runners_app    DATABASE     ~   CREATE DATABASE runners_app WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Polish_Poland.1250';
    DROP DATABASE runners_app;
                postgres    false            �            1259    16421 
   run_detail    TABLE     �   CREATE TABLE public.run_detail (
    run_id integer,
    max_hb integer,
    avg_hb integer,
    avg_cadence integer,
    step_length integer
);
    DROP TABLE public.run_detail;
       public         heap    postgres    false            �            1259    16400    runners    TABLE     �   CREATE TABLE public.runners (
    runner_id integer NOT NULL,
    first_name character varying NOT NULL,
    last_name character varying NOT NULL
);
    DROP TABLE public.runners;
       public         heap    postgres    false            �            1259    16399    runners_runner_id_seq    SEQUENCE     �   CREATE SEQUENCE public.runners_runner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.runners_runner_id_seq;
       public          postgres    false    216            �           0    0    runners_runner_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.runners_runner_id_seq OWNED BY public.runners.runner_id;
          public          postgres    false    215            �            1259    16409    running_results    TABLE     �   CREATE TABLE public.running_results (
    run_id integer NOT NULL,
    runner_id integer,
    "time" time without time zone NOT NULL,
    distance numeric(5,2),
    CONSTRAINT running_results_distance_check CHECK ((distance > (0)::numeric))
);
 #   DROP TABLE public.running_results;
       public         heap    postgres    false            �            1259    16408    running_results_run_id_seq    SEQUENCE     �   CREATE SEQUENCE public.running_results_run_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.running_results_run_id_seq;
       public          postgres    false    218            �           0    0    running_results_run_id_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.running_results_run_id_seq OWNED BY public.running_results.run_id;
          public          postgres    false    217            #           2604    16403    runners runner_id    DEFAULT     v   ALTER TABLE ONLY public.runners ALTER COLUMN runner_id SET DEFAULT nextval('public.runners_runner_id_seq'::regclass);
 @   ALTER TABLE public.runners ALTER COLUMN runner_id DROP DEFAULT;
       public          postgres    false    215    216    216            $           2604    16412    running_results run_id    DEFAULT     �   ALTER TABLE ONLY public.running_results ALTER COLUMN run_id SET DEFAULT nextval('public.running_results_run_id_seq'::regclass);
 E   ALTER TABLE public.running_results ALTER COLUMN run_id DROP DEFAULT;
       public          postgres    false    218    217    218            �          0    16421 
   run_detail 
   TABLE DATA           V   COPY public.run_detail (run_id, max_hb, avg_hb, avg_cadence, step_length) FROM stdin;
    public          postgres    false    219   �       �          0    16400    runners 
   TABLE DATA           C   COPY public.runners (runner_id, first_name, last_name) FROM stdin;
    public          postgres    false    216   �       �          0    16409    running_results 
   TABLE DATA           N   COPY public.running_results (run_id, runner_id, "time", distance) FROM stdin;
    public          postgres    false    218   "       �           0    0    runners_runner_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.runners_runner_id_seq', 2, true);
          public          postgres    false    215            �           0    0    running_results_run_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.running_results_run_id_seq', 4, true);
          public          postgres    false    217            '           2606    16407    runners runners_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.runners
    ADD CONSTRAINT runners_pkey PRIMARY KEY (runner_id);
 >   ALTER TABLE ONLY public.runners DROP CONSTRAINT runners_pkey;
       public            postgres    false    216            )           2606    16415 $   running_results running_results_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.running_results
    ADD CONSTRAINT running_results_pkey PRIMARY KEY (run_id);
 N   ALTER TABLE ONLY public.running_results DROP CONSTRAINT running_results_pkey;
       public            postgres    false    218            *           2606    16416    running_results fk_runners    FK CONSTRAINT     �   ALTER TABLE ONLY public.running_results
    ADD CONSTRAINT fk_runners FOREIGN KEY (runner_id) REFERENCES public.runners(runner_id);
 D   ALTER TABLE ONLY public.running_results DROP CONSTRAINT fk_runners;
       public          postgres    false    218    4647    216            +           2606    16424    run_detail fk_running_results    FK CONSTRAINT     �   ALTER TABLE ONLY public.run_detail
    ADD CONSTRAINT fk_running_results FOREIGN KEY (run_id) REFERENCES public.running_results(run_id);
 G   ALTER TABLE ONLY public.run_detail DROP CONSTRAINT fk_running_results;
       public          postgres    false    218    219    4649            �   +   x�3�4�4�447�44����r�,9MM8��@1z\\\ �Zb      �   5   x�3�(�Jͭ,�I,����I��2���M,���L��<�R������� e��      �   -   x�3�4�40�2��25�4�30�2��ZXs�[r��qqq ���     