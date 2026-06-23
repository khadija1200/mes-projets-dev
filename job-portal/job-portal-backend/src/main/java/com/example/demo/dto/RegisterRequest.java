package com.example.demo.dto;

import com.example.demo.model.Role;
import lombok.Data;

@Data
public class RegisterRequest {

    private String email;
    private String password;
    private Role role;

    // recruiter fields (optionnel)
    private String companyName;
    private String address;
}