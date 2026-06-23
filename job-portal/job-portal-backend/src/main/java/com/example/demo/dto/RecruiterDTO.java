package com.example.demo.dto;

public class RecruiterDTO {

    private Long id;
    private String companyName;

    public RecruiterDTO(Long id, String companyName) {
        this.id = id;
        this.companyName = companyName;
    }

    public Long getId() {
        return id;
    }

    public String getCompanyName() {
        return companyName;
    }
}