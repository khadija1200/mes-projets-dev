package com.example.demo.dto;

import com.example.demo.model.Role;
import lombok.AllArgsConstructor;
import lombok.Data;

@Data
@AllArgsConstructor
public class LoginResponse {
    private Long id;
    private String email;
    private Role role;
}