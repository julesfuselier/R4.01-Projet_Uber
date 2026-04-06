package fr.univamu.iut.menu;

import jakarta.ws.rs.GET;
import jakarta.ws.rs.Path;
import jakarta.ws.rs.Produces;

import java.util.ArrayList;

@Path("/hello-world")
public class MenuResource {

    @GET
    @Produces("text/plain")
    public String hello() {
        return "Hello world";
    }
}