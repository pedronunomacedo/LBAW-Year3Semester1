--
-- PostgreSQL database dump
--

-- Dumped from database version 15.0 (Debian 15.0-1.pgdg110+1)
-- Dumped by pg_dump version 15.0 (Debian 15.0-1.pgdg110+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: email_format; Type: DOMAIN; Schema: public; Owner: -
--

CREATE DOMAIN public.email_format AS text
	CONSTRAINT email_format_check CHECK ((VALUE ~~ '_%@_%.__%'::text));


--
-- Name: order_state; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE public.order_state AS ENUM (
    'In process',
    'Preparing',
    'Dispatched',
    'Delivered',
    'Cancelled'
);


--
-- Name: product_category; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE public.product_category AS ENUM (
    'Smartphones',
    'Components',
    'TVs',
    'Laptops',
    'Desktops',
    'Other'
);


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: administrator; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.administrator (
    id integer
);


--
-- Name: adress; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.adress (
    id integer NOT NULL,
    street character varying(255) NOT NULL,
    postalcode character varying(255) NOT NULL,
    city character varying(255) NOT NULL,
    country character varying(255) NOT NULL
);


--
-- Name: adress_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.adress_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: adress_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.adress_id_seq OWNED BY public.adress.id;


--
-- Name: authenticateduser; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.authenticateduser (
    id integer,
    idaddress integer
);


--
-- Name: demo; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.demo (
    id integer NOT NULL,
    name character varying(200) DEFAULT ''::character varying NOT NULL,
    hint text DEFAULT ''::text NOT NULL
);


--
-- Name: demo_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.demo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: demo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.demo_id_seq OWNED BY public.demo.id;


--
-- Name: faq; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.faq (
    id integer NOT NULL,
    question character varying(255) NOT NULL,
    answer character varying(255) NOT NULL
);


--
-- Name: faq_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.faq_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: faq_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.faq_id_seq OWNED BY public.faq.id;


--
-- Name: notificationn; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.notificationn (
    content character varying(255) NOT NULL,
    notificationdate date NOT NULL,
    iduser integer NOT NULL,
    idorder integer NOT NULL
);


--
-- Name: orders; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    idaddress integer,
    idproduct integer,
    orderdate date NOT NULL,
    orderstate public.order_state DEFAULT 'In process'::public.order_state NOT NULL
);


--
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- Name: product; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product (
    id integer NOT NULL,
    prodname character varying(255) NOT NULL,
    price double precision NOT NULL,
    proddescription character varying(500) NOT NULL,
    prodimageid integer NOT NULL,
    launchdate date NOT NULL,
    stock integer NOT NULL,
    categoryname public.product_category NOT NULL,
    CONSTRAINT product_stock_check CHECK ((stock >= 0))
);


--
-- Name: product_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.product_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: product_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.product_id_seq OWNED BY public.product.id;


--
-- Name: productimages; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.productimages (
    id integer NOT NULL,
    idproduct integer,
    imagepath character varying(255) NOT NULL
);


--
-- Name: productimages_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.productimages_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: productimages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.productimages_id_seq OWNED BY public.productimages.id;


--
-- Name: productpurchase; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.productpurchase (
    quantity integer,
    totalprice double precision NOT NULL,
    idproduct integer NOT NULL,
    idorder integer NOT NULL,
    CONSTRAINT productpurchase_quantity_check CHECK ((quantity >= 0))
);


--
-- Name: review; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.review (
    id integer NOT NULL,
    iduser integer,
    idproduct integer,
    reviewdate date NOT NULL,
    content character varying(500) NOT NULL,
    rating integer,
    CONSTRAINT review_rating_check CHECK (((rating >= 0) AND (rating <= 5)))
);


--
-- Name: review_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.review_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: review_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.review_id_seq OWNED BY public.review.id;


--
-- Name: shopcart; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.shopcart (
    quantity integer,
    idproduct integer NOT NULL,
    iduser integer NOT NULL,
    CONSTRAINT shopcart_quantity_check CHECK ((quantity >= 0))
);


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    phonenumber character varying(255),
    pass character varying(255) NOT NULL
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: whishlist; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.whishlist (
    quantity integer,
    idproduct integer NOT NULL,
    iduser integer NOT NULL,
    CONSTRAINT whishlist_quantity_check CHECK ((quantity >= 0))
);


--
-- Name: adress id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.adress ALTER COLUMN id SET DEFAULT nextval('public.adress_id_seq'::regclass);


--
-- Name: demo id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.demo ALTER COLUMN id SET DEFAULT nextval('public.demo_id_seq'::regclass);


--
-- Name: faq id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.faq ALTER COLUMN id SET DEFAULT nextval('public.faq_id_seq'::regclass);


--
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- Name: product id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product ALTER COLUMN id SET DEFAULT nextval('public.product_id_seq'::regclass);


--
-- Name: productimages id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productimages ALTER COLUMN id SET DEFAULT nextval('public.productimages_id_seq'::regclass);


--
-- Name: review id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.review ALTER COLUMN id SET DEFAULT nextval('public.review_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: adress adress_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.adress
    ADD CONSTRAINT adress_pkey PRIMARY KEY (id);


--
-- Name: demo demo_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.demo
    ADD CONSTRAINT demo_pkey PRIMARY KEY (id);


--
-- Name: faq faq_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.faq
    ADD CONSTRAINT faq_pkey PRIMARY KEY (id);


--
-- Name: notificationn notificationn_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.notificationn
    ADD CONSTRAINT notificationn_pkey PRIMARY KEY (idorder, iduser);


--
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- Name: product product_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT product_pkey PRIMARY KEY (id);


--
-- Name: productimages productimages_imagepath_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productimages
    ADD CONSTRAINT productimages_imagepath_key UNIQUE (imagepath);


--
-- Name: productimages productimages_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productimages
    ADD CONSTRAINT productimages_pkey PRIMARY KEY (id);


--
-- Name: productpurchase productpurchase_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productpurchase
    ADD CONSTRAINT productpurchase_pkey PRIMARY KEY (idorder, idproduct);


--
-- Name: review review_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.review
    ADD CONSTRAINT review_pkey PRIMARY KEY (id);


--
-- Name: shopcart shopcart_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.shopcart
    ADD CONSTRAINT shopcart_pkey PRIMARY KEY (idproduct, iduser);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_phonenumber_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_phonenumber_key UNIQUE (phonenumber);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: whishlist whishlist_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.whishlist
    ADD CONSTRAINT whishlist_pkey PRIMARY KEY (idproduct, iduser);


--
-- Name: administrator administrator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.administrator
    ADD CONSTRAINT administrator_id_fkey FOREIGN KEY (id) REFERENCES public.users(id);


--
-- Name: authenticateduser authenticateduser_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.authenticateduser
    ADD CONSTRAINT authenticateduser_id_fkey FOREIGN KEY (id) REFERENCES public.users(id);


--
-- Name: authenticateduser authenticateduser_idaddress_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.authenticateduser
    ADD CONSTRAINT authenticateduser_idaddress_fkey FOREIGN KEY (idaddress) REFERENCES public.adress(id);


--
-- Name: notificationn notificationn_idorder_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.notificationn
    ADD CONSTRAINT notificationn_idorder_fkey FOREIGN KEY (idorder) REFERENCES public.orders(id);


--
-- Name: notificationn notificationn_iduser_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.notificationn
    ADD CONSTRAINT notificationn_iduser_fkey FOREIGN KEY (iduser) REFERENCES public.users(id);


--
-- Name: orders orders_idaddress_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_idaddress_fkey FOREIGN KEY (idaddress) REFERENCES public.adress(id);


--
-- Name: orders orders_idproduct_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_idproduct_fkey FOREIGN KEY (idproduct) REFERENCES public.product(id);


--
-- Name: productimages productimages_idproduct_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productimages
    ADD CONSTRAINT productimages_idproduct_fkey FOREIGN KEY (idproduct) REFERENCES public.product(id);


--
-- Name: productpurchase productpurchase_idorder_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productpurchase
    ADD CONSTRAINT productpurchase_idorder_fkey FOREIGN KEY (idorder) REFERENCES public.orders(id);


--
-- Name: productpurchase productpurchase_idproduct_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.productpurchase
    ADD CONSTRAINT productpurchase_idproduct_fkey FOREIGN KEY (idproduct) REFERENCES public.product(id);


--
-- Name: review review_idproduct_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.review
    ADD CONSTRAINT review_idproduct_fkey FOREIGN KEY (idproduct) REFERENCES public.product(id);


--
-- Name: review review_iduser_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.review
    ADD CONSTRAINT review_iduser_fkey FOREIGN KEY (iduser) REFERENCES public.users(id);


--
-- Name: shopcart shopcart_idproduct_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.shopcart
    ADD CONSTRAINT shopcart_idproduct_fkey FOREIGN KEY (idproduct) REFERENCES public.product(id);


--
-- Name: shopcart shopcart_iduser_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.shopcart
    ADD CONSTRAINT shopcart_iduser_fkey FOREIGN KEY (iduser) REFERENCES public.users(id);


--
-- Name: whishlist whishlist_idproduct_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.whishlist
    ADD CONSTRAINT whishlist_idproduct_fkey FOREIGN KEY (idproduct) REFERENCES public.product(id);


--
-- Name: whishlist whishlist_iduser_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.whishlist
    ADD CONSTRAINT whishlist_iduser_fkey FOREIGN KEY (iduser) REFERENCES public.users(id);


--
-- PostgreSQL database dump complete
--

